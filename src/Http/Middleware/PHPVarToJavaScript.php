<?php


namespace Sco\Admin\Http\Middleware;

use Auth;
use JavaScript;
use Illuminate\Http\Request;

class PHPVarToJavaScript
{
    public function handle(Request $request, \Closure $next)
    {
        config([
            'javascript.bind_js_vars_to_this_view' => 'admin::partials.script',
            'javascript.js_namespace' => 'window.Admin'
        ]);
        $js = [
            'Lang' => config('app.locale'),
            'Title' => config('admin.title'),
        ];
        if (Auth::check()) {
            $js['LoggedUser'] = [
                'id' => Auth::id(),
                'name' => Auth::user()->name,
                'role' => Auth::user()->roles->makeHidden(['description', 'created_at', 'updated_at', 'pivot', 'perms'])->first(null, collect())
            ];
        }

        JavaScript::put($js);
        return $next($request);
    }
}
