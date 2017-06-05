<?php

namespace Sco\Admin\Http\Middleware;

use Auth;
use Closure;
use Route;
use Sco\Admin\Models\Permission;

class AdminMenu
{
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
                $menu = [
                    'title' => $items,
                    'url'   => $this->getRouteUrl('admin.' . $items),
                    'child' => [],
                ];
                $menus->push($menu);
            } elseif (is_array($items)) { // child
                $childs = $this->getAdminMenu($items);
                if (!empty($childs)) {
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
