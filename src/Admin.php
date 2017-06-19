<?php


namespace Sco\Admin;

use Auth;
use Illuminate\Support\Collection;
use Route;
use Illuminate\Foundation\Application;
use Sco\Admin\Config\ConfigFactory;
use Sco\Admin\Config\ModelFactory;
use Sco\Admin\Contracts\Admin as AdminContract;
use Illuminate\Config\Repository as ConfigRepository;

class Admin implements AdminContract
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    protected $models;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->config = new ConfigRepository(
            $this->app['config']->get('admin', [])
        );

        $this->models = new Collection();
    }

    public function getMenus($list = null)
    {
        $list = $list ?: $this->config->get('menus');
        $menus = collect();
        foreach ($list as $key => $items) {
            if (is_string($items)) {
                if (Route::has($items)) {
                    if (Auth::user()->can($items)) {
                        $menus->push([
                            'title' => $key,
                            'url'   => route($items, [], false),
                            'child' => [],
                        ]);
                    }
                } else {
                    $config = $this->getConfig($items);
                    if ($config && $config->getPermissions()->isViewable()) {
                        $menus->push([
                            'title' => $config->getTitle(),
                            'url'   => route('admin.model.index', ['model' => $items], false),
                            'child' => [],
                        ]);
                    }
                }
            } elseif (is_array($items)) { // child
                $childs = $this->getMenus($items);
                if ($childs->isNotEmpty()) {
                    $menu = [
                        'title' => $key,
                        'url'   => '/#',
                        'child' => $childs,
                    ];
                    $menus->push($menu);
                }
            }
        }
        return $menus;
    }

    /**
     * @param $name
     *
     * @return \Sco\Admin\Contracts\Config
     */
    public function getConfig($name)
    {
        if (!$this->models->has($name)) {
            $this->models->put($name, new ConfigFactory($this->app, $name));
        }

        return $this->models->get($name);
    }
}
