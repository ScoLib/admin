<?php

namespace Sco\Admin\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Sco\Admin\Contracts\ConfigFactoryInterface;

class ModelAuthorize
{
    const DELIMITER = '|';

    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory $auth
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Closure                  $next
     * @param string                   $permissions
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function handle($request, Closure $next, $permissions = '')
    {
        if (empty($permissions)) {
            throw new AuthorizationException();
        }

        if (!is_array($permissions)) {
            $permissions = explode(self::DELIMITER, $permissions);
        }

        if ($this->auth->guest() || !app(ConfigFactoryInterface::class)->getPermissions()->can($permissions)) {
            throw new AuthorizationException();
        }

        return $next($request);
    }
}
