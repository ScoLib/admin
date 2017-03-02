<?php

namespace Sco\Admin\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string|null              $guard
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard(config('admin.guard'))->check()) {
            return redirect()->route('admin.index');
        }

        return $next($request);
    }
}
