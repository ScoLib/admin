<?php

namespace Sco\Admin\Component;

use BadMethodCallException;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Illuminate\Foundation\Application;
use Sco\Admin\Component\Concerns\HasAccess;
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
    use HasAccess, HasEvents, HasNavigation;

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

    public function __construct(Application $app, $modelClass)
    {
        $this->app = $app;

        $this->repository = $this->app->make(RepositoryInterface::class);
        $this->repository->setClass($modelClass);

        $this->model = $this->repository->getModel();
        if (!$this->name) {
            $this->setDefaultName();
        }

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

    public function getAccesses()
    {
        return static::$abilities->mapWithKeys(function ($item, $key) {
            return [$key => $this->can($item)];
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigs()
    {
        return collect([
            //'primaryKey'  => $this->getModel()->getKeyName(),
            'title'    => $this->getTitle(),
            'accesses' => $this->getAccesses(),
            'view'     => $this->fireView(),
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

            static::boot();

            $this->fireEvent('booted', false);
        }
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        static::bootTraits();
    }

    /**
     * Boot all of the bootable traits on the model.
     *
     * @return void
     */
    protected static function bootTraits()
    {
        $class = static::class;

        foreach (class_uses_recursive($class) as $trait) {
            if (method_exists($class, $method = 'boot'.class_basename($trait))) {
                forward_static_call([$class, $method]);
            }
        }
    }
}
