<?php


namespace Sco\Admin\Http\Middleware;

use Auth;
use Illuminate\Http\Request;

class Permissions
{
    public function handle(Request $request, \Closure $next)
    {
        $request->attributes->set('admin.permissions', $this->getAdminPermissions());
        return $next($request);
    }

    protected function getAdminPermissions()
    {
        $perms = collect();
        foreach (Auth::user()->roles as $role) {
            foreach ($role->perms as $perm) {
                if ($perm->name != '#') {
                    $perms->push($perm->name);
                }
            }
        }
        return $perms;
    }
}
