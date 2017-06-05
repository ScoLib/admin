<?php

namespace Sco\Admin\Http\Middleware;

use Closure;
use Route;
use Sco\Admin\Config\Factory as ConfigFactory;

class AdminMenu
{
    protected $configFactory;

    public function __construct(ConfigFactory $configFactory)
    {
        $this->configFactory = $configFactory;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->attributes->set('admin.menu',
            $this->getAdminMenu(config('admin.menus')));
        return $next($request);
    }

    protected function getAdminMenu($list)
    {
        $menus = collect();
        foreach ($list as $key => $items) {
            if (is_string($items)) {
                $config = $this->configFactory->make($items);
                if ($config && $config->getAttribute('permission')) {
                    $menus->push([
                        'title' => $config->getAttribute('title'),
                        'url'   => $this->getRouteUrl('admin.' . $items),
                        'child' => [],
                    ]);
                }
            } elseif (is_array($items)) { // child
                $childs = $this->getAdminMenu($items);
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

    private function getRouteUrl($name)
    {
        return Route::has($name) ? route($name, [], false)
            : ('/' . str_replace('.', '/', $name));

    }
}
