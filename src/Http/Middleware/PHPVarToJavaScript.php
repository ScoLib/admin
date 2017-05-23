<?php


namespace Sco\Admin\Http\Middleware;

use Auth;
use Illuminate\Http\Request;

class PHPVarToJavaScript
{
    public function handle(Request $request, \Closure $next)
    {
        config([
            'javascript.bind_js_vars_to_this_view' => 'admin::partials.head',
        ]);
        JavaScript::put([
            'Lang' => config('app.locale'),
            'LoggedUser' => [
                'id' => Auth::id(),
                'name' => Auth::user()->name,
                'role' => Auth::user()->roles->makeHidden(['description', 'created_at', 'updated_at', 'pivot', 'perms'])->first(null, collect())
            ],
            'PermList' => request()->attributes->get('admin.permissions', collect())
        ]);
        return $next($request);
    }

}
