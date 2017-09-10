<?php

namespace Sco\Admin\Exceptions;

class AuthenticationException extends \Exception
{
    protected $message;

    public function __construct($message = 'Unauthenticated.')
    {
        parent::__construct($message);
        $this->message = $message;
    }

    public function render($request)
    {
        return $request->expectsJson()
            ? response()->json(['message' => $this->message], 401)
            : redirect()->guest(route('admin.login'));
    }
}
