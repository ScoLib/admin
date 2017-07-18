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

    public function __construct(Application $app = null, $modelClass = null)
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

            //static::bootTraits();

            $this->boot();

            $this->fireEvent('booted', false);
        }
    }

    public function boot()
    {
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
            if (method_exists($class, $method = 'boot' . class_basename($trait))) {
                forward_static_call([$class, $method]);
            }
        }
    }
}
