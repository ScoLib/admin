<?php

namespace Sco\Admin\Http\Middleware;

use Closure;
use Auth;
use Sco\Admin\Exceptions\AuthenticationException;

class Authenticate
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     * @throws \Sco\Admin\Exceptions\AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        $this->authenticate();

        return $next($request);
    }

    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @return mixed
     * @throws \Sco\Admin\Exceptions\AuthenticationException
     */
    protected function authenticate()
    {
        if (Auth::check()) {
            return Auth::user();
        }

        throw new AuthenticationException();
    }
}
