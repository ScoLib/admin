<?php

namespace Sco\Admin\Http\Middleware;

use Auth;
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
                $name = 'admin.' . $items;
                if (Route::has($name)) {
                    if (Auth::user()->can($name)) {
                        $menus->push([
                            'title' => $key,
                            'url'   => route($name),
                            'child' => [],
                        ]);
                    }
                } else {
                    $config = $this->configFactory->make($items);
                    if ($config && $config->getAttribute('permissions.view')) {
                        $menus->push([
                            'title' => $config->getAttribute('title'),
                            'url'   => ('/' . str_replace('.', '/', $name)),
                            'child' => [],
                        ]);
                    }
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
}
