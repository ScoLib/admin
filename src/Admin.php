<?php


namespace Sco\Admin;

use Auth;
use Route;
use Illuminate\Foundation\Application;
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

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->config = new ConfigRepository(
            $this->app['config']->get('admin', [])
        );
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
                    if ($config && $config->getAttribute('permissions.view')) {
                        $menus->push([
                            'title' => $config->getAttribute('title'),
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

    public function getConfig($name)
    {
        return $this->app['admin.config.factory']->make($name);
    }
}
