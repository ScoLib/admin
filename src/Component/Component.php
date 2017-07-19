<?php

namespace Sco\Admin\Component;

use Illuminate\Foundation\Application;
use Sco\Admin\Component\Concerns\HasEvents;
use Sco\Admin\Component\Concerns\HasPermission;
use Sco\Admin\Contracts\ComponentInterface;
use Sco\Admin\Contracts\RepositoryInterface;

abstract class Component implements ComponentInterface
{
    use HasEvents, HasPermission;

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
     * @return array
     */
    abstract public function getColumns();

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
        return snake_case(str_plural(class_basename(get_class($this->getModel()))));
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

    public function get()
    {
        if (!method_exists($this, 'callView')) {
            return;
        }

        $view = $this->app->call([$this, 'callView']);
        $view->setRepository($this->getRepository());

        return $view->get();
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
            'columns'     => $this->getColumns(),
            //'elements'    => $this->getElements()->values(),
        ]);
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
}
