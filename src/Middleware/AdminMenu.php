<?php

namespace Sco\Admin\Middleware;

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
        $request->attributes->set('admin.menu', $this->getAdminMenu());
        $request->attributes->set('currentMenuIds', $this->getCurrentMenuIds());
        return $next($request);
    }

    protected function getAdminMenu()
    {
        return (new Permission())->getMenuList();
    }

    protected function getCurrentMenuIds()
    {
        $parentTree = (new Permission())->getParentTreeAndSelfByName(Route::currentRouteName());
        $currentMenuIds = 0;
        if ($parentTree) {
            $currentMenuIds = $parentTree->pluck('id');
        }

        return $currentMenuIds;
    }
}
