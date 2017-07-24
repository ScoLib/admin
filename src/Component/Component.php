<?php

namespace Sco\Admin\Component;

use Illuminate\Foundation\Application;
use Sco\Admin\Component\Concerns\HasEvents;
use Sco\Admin\Component\Concerns\HasNavigation;
use Sco\Admin\Component\Concerns\HasPermission;
use Sco\Admin\Contracts\ComponentInterface;
use Sco\Admin\Contracts\RepositoryInterface;
use Sco\Admin\Exceptions\BadMethodCallException;

abstract class Component implements ComponentInterface
{
    use HasEvents,
        HasPermission,
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
        $view = $this->fireView();

        $this->getRepository();

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
            'view'        => $this->fireView(),
            //'elements'    => $this->getElements()->values(),
        ]);
    }

    /**
     * @return \Sco\Admin\Contracts\ViewInterface
     */
    protected function fireView()
    {
        if (!method_exists($this, 'callView')) {
            throw new BadMethodCallException('Not Found Method "callView"');
        }

        $view = $this->app->call([$this, 'callView']);
        return $view;
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
