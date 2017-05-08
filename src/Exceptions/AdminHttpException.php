<?php

namespace Sco\Admin\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class AdminHttpException extends HttpException
{
    public function __construct(
        $message,
        $statusCode = 404,
        \Exception $previous = null,
        array $headers = [],
        $code = 0
    ) {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }
}
