<?php

namespace Sco\Admin\Component;

use BadMethodCallException;
use Illuminate\Database\Eloquent\Model;
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

    /**
     * The component display name
     *
     * @var string
     */
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

    abstract public function model();

    public function __construct(Application $app, RepositoryInterface $repository)
    {
        $this->app = $app;

        $this->makeModel();

        $this->repository = $repository;
        $this->repository->setModel($this->getModel());

        if (!$this->name) {
            $this->setDefaultName();
        }

        $this->bootIfNotBooted();
    }

    protected function setDefaultName()
    {
        $this->name = $this->getModelClassName();
    }

    /**
     * @return string
     */
    protected function getModelClassName()
    {
        return snake_case( // 蛇形命名
            str_plural( // 复数
                class_basename(
                    get_class($this->getModel())
                )
            )
        );
    }

    public function getModel()
    {
        return $this->model;
    }

    protected function makeModel()
    {
        $class = $this->model();
        if (empty($class)) {
            throw new InvalidArgumentException(
                sprintf(
                    'The component(%s) method "model()" not found value',
                    get_class($this)
                )
            );
        }

        $model = $this->app->make($this->model());

        if (!($model instanceof Model)) {
            throw new InvalidArgumentException(
                sprintf(
                    "Class %s must be an instance of %s",
                    $this->model(),
                    Model::class
                )
            );
        }

        return $this->model = $model;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTitle()
    {
        return $this->title;
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
            'title'    => $this->getTitle(),
            'accesses' => $this->getAccesses(),
            'view'     => $this->fireView(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    final public function fireView()
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

        $view->setModel($this->getModel());
        $view->initialize();

        return $view;
    }

    public function get()
    {
        $view = $this->fireView();

        // $view->setRepository($this->getRepository());

        return $view->get();
    }

    /**
     * {@inheritdoc}
     */
    final public function fireCreate()
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
    final public function fireEdit($id)
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
        $this->getRepository()->delete($id);
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

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected function boot()
    {
        $this->bootTraits();
    }

    /**
     * Boot all of the bootable traits on the model.
     *
     * @return void
     */
    protected function bootTraits()
    {
        foreach (class_uses_recursive($this) as $trait) {
            if (method_exists($this, $method = 'boot' . class_basename($trait))) {
                $this->$method();
            }
        }
    }
}
