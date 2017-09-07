<?php

namespace Sco\Admin\Component;

use BadMethodCallException;
use InvalidArgumentException;
use Illuminate\Foundation\Application;
use Sco\Admin\Component\Concerns\HasEvents;
use Sco\Admin\Component\Concerns\HasNavigation;
use Sco\Admin\Contracts\ComponentInterface;
use Sco\Admin\Contracts\Form\FormInterface;
use Sco\Admin\Contracts\RepositoryInterface;
use Sco\Admin\Contracts\View\ViewInterface;
use Sco\Admin\Contracts\WithNavigation;

abstract class Component implements
    ComponentInterface,
    WithNavigation
{
    use HasEvents,
        HasNavigation;

    /**
     * @var
     */
    protected $name;

    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    protected $title;

    /**
     * @var mixed|\Sco\Admin\Contracts\RepositoryInterface
     */
    protected $repository;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    protected static $booted = [];

    /**
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected static $dispatcher;

    /**
     * @var string
     */
    protected $permissionObserver;

    protected $permissions;

    protected $permissionMethods = [
        'view', 'create', 'edit',
        'delete', 'destroy', 'restore',
    ];

    public function __construct(Application $app, $modelClass)
    {
        $this->app = $app;

        $this->repository = $this->app->make(RepositoryInterface::class);
        $this->repository->setClass($modelClass);

        $this->model = $this->repository->getModel();
        if (!$this->name) {
            $this->setDefaultName();
        }

        $this->registerObserver($this->permissionObserver);

        $this->bootIfNotBooted();
    }

    protected function setDefaultName()
    {
        $this->name = $this->getModelClassName();
    }

    protected function getModelClassName()
    {
        return snake_case(
            str_plural(
                class_basename(
                    get_class($this->getModel())
                )
            )
        );
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigs()
    {
        return collect([
            'primaryKey'  => $this->getModel()->getKeyName(),
            'title'       => $this->getTitle(),
            'permissions' => $this->getPermissions(),
            'view'        => $this->fireView(),
            //'elements'    => $this->getElements()->values(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function fireView()
    {
        if (!method_exists($this, 'callView')) {
            throw new BadMethodCallException('Not Found Method "callView"');
        }

        $view = $this->app->call([$this, 'callView']);

        if (!$view instanceof ViewInterface) {
            throw new InvalidArgumentException(
                sprintf(
                    'callView must be instanced of "%s".',
                    ViewInterface::class
                )
            );
        }

        return $view;
    }

    public function get()
    {
        $view = $this->fireView();

        $this->getRepository();

        $view->setRepository($this->getRepository());

        return $view->get();
    }

    /**
     * {@inheritdoc}
     */
    public function fireCreate()
    {
        if (!method_exists($this, 'callCreate')) {
            return;
        }

        $form = $this->app->call([$this, 'callCreate']);
        if (!$form instanceof FormInterface) {
            throw new InvalidArgumentException(
                sprintf(
                    'callCreate must be instanced of "%s".',
                    FormInterface::class
                )
            );
        }

        $form->setModel($this->getModel());

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function store()
    {
        $form = $this->fireCreate();

        $form->validate()->save();
    }

    /**
     * {@inheritdoc}
     */
    public function fireEdit($id)
    {
        if (!method_exists($this, 'callEdit')) {
            return;
        }

        $form = $this->app->call([$this, 'callEdit'], ['id' => $id]);

        if (!$form instanceof FormInterface) {
            throw new InvalidArgumentException(
                sprintf(
                    'callEdit must be instanced of "%s".',
                    FormInterface::class
                )
            );
        }

        $model = $this->getRepository()->findOrFail($id);

        $form->setModel($model);

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id)
    {
        $form = $this->fireEdit($id);
        $form->validate()->save();
    }

    public function delete($id)
    {
        $this->getRepository()->findOrFail($id)->delete();
        return true;
    }

    public function forceDelete($id)
    {
        $this->getRepository()->forceDelete($id);
        return true;
    }

    public function restore($id)
    {
        $this->getRepository()->restore($id);
        return true;
    }

    protected function bootIfNotBooted()
    {
        if (!isset(static::$booted[static::class])) {
            static::$booted[static::class] = true;

            $this->fireEvent('booting', false);

            $this->boot();

            $this->fireEvent('booted', false);
        }
    }

    public function boot()
    {
        return true;
    }

    public function isView()
    {
        return method_exists($this, 'callView') && $this->can('view');
    }

    public function isCreate()
    {
        return method_exists($this, 'callCreate') && $this->can('create');
    }

    public function isEdit()
    {
        return method_exists($this, 'callEdit') && $this->can('edit');
    }

    public function isDelete()
    {
        return $this->can('delete');
    }

    public function isDestroy()
    {
        return $this->isRestorableModel() && $this->can('destroy');
    }

    public function isRestore()
    {
        return $this->isRestorableModel() && $this->can('restore');
    }

    protected function isRestorableModel()
    {
        return $this->getRepository()->isRestorable();
    }

    public function registerObserver($class = null)
    {
        if (!$class) {
            return;
        }

        $className = is_string($class) ? $class : get_class($class);

        foreach ($this->permissionMethods as $method) {
            if (method_exists($class, $method)) {
                $this->registerPermission(
                    $method,
                    [$this->app->make($className), $method]
                );
            }
        }
    }

    public function registerPermission($permission, $callback)
    {
        $this->permissions[$permission] = $callback;
    }

    public function can($permission)
    {
        if (is_callable($this->permissions[$permission])) {
            return call_user_func_array($this->permissions[$permission], [$this]);
        }
        return $this->permissions[$permission] ? true : false;
    }

    public function getPermissions()
    {
        $data = collect();
        foreach ($this->permissionMethods as $perm) {
            $method = 'is' . ucfirst($perm);
            if (!method_exists($this, $method)) {
                $method = 'can';
            }

            $data->put($perm, $this->{$method}($perm));
        }
        return $data;
    }
}
