<?php

namespace Sco\Admin\Http\Middleware;

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
        return $next($request);
    }

    protected function getAdminMenu()
    {
        return $this->checkMenuPermission((new Permission())->getMenuList());

    }

    private function checkMenuPermission($list)
    {

        $return = $list->filter(function ($permission, $key) {
            if (request()->user()->can($permission->name)) {
                if (!$permission->child->isEmpty()) {
                    $permission->child = $this->checkMenuPermission($permission->child);
                }
                return $permission;
            }
        });

        return $return;
    }
}
