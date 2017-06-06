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
                if (Route::has($items)) {
                    if (Auth::user()->can($items)) {
                        $menus->push([
                            'title' => $key,
                            'url'   => route($items, [], false),
                            'child' => [],
                        ]);
                    }
                } else {
                    $config = $this->configFactory->make($items);
                    if ($config && $config->getAttribute('permissions.view')) {
                        $model = str_replace('.', '/', $items);
                        $menus->push([
                            'title' => $config->getAttribute('title'),
                            'url'   => route('admin.model.index', ['model' => $model], false),
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
