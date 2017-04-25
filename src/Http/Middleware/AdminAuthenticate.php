<?php

namespace Sco\Admin\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Route;
use URL;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|mixed|\Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        $guard = config('admin.guard');
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                $url = route('admin.login');

                return redirect()->guest($url);
            }
        }

        Auth::shouldUse($guard);

        if (!$request->user()->can(Route::currentRouteName())) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
                //return response()->json(error('您没有权限执行此操作'));
            } else {
                $previousUrl = URL::previous();

                return response()->view('admin::errors.403',
                    compact('previousUrl'));
            }
        }

        return $next($request);
    }
}
