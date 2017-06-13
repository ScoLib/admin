<?php


namespace Sco\Admin\Http\Middleware;

use Closure;

class ResolveConfigInstance
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->route() && $request->route('model')) {
            $model = $request->route('model');
            app()->singleton(
                'admin.config.instance',
                function ($app) use ($model) {
                    return $app->make('admin.config.factory')->makeFromUri($model);
                });
        }

        return $next($request);
    }
}
