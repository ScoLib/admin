<?php

namespace Sco\Admin\Component;

use Illuminate\Foundation\Application;
use KodiComponents\Navigation\Contracts\BadgeInterface;
use Sco\Admin\Component\Concerns\HasEvents;
use Sco\Admin\Component\Concerns\HasPermission;
use Sco\Admin\Contracts\ComponentInterface;
use Sco\Admin\Contracts\RepositoryInterface;
use Sco\Admin\Navigation\Badge;
use Sco\Admin\Navigation\Page;

abstract class Component implements ComponentInterface
{
    use HasEvents, HasPermission;

    protected $name;

    protected $app;

    protected $title;

    protected $repository;

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
            //'columns'     => $this->getColumns()->values(),
            //'elements'    => $this->getElements()->values(),
        ]);
    }

    /**
     * @return \KodiComponents\Navigation\Contracts\NavigationInterface
     */
    public function getNavigation()
    {
        return $this->app['admin.navigation'];
    }

    /**
     * 添加菜单
     *
     * @param int  $priority
     * @param null $badge
     *
     * @return \Sco\Admin\Navigation\Page
     */
    public function addToNavigation($priority = 100, $badge = null)
    {
        $page = $this->makePage($priority, $badge);
        $this->getNavigation()->addPage($page);
        return $page;
    }

    /**
     * page
     *
     * @param int  $priority
     * @param null $badge
     *
     * @return \Sco\Admin\Navigation\Page
     */
    protected function makePage($priority = 100, $badge = null)
    {
        $page = new Page($this->getTitle());
        $page->setPriority($priority);
        if ($badge) {
            if (!($badge instanceof BadgeInterface)) {
                $badge = new Badge($badge);
            }
            $page->addBadge($badge);
        }

        return $page;
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
