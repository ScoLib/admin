<?php

namespace Sco\Admin\Exceptions;

use Sco\Admin\Contracts\ExceptionInterface;

class BadMethodCallException extends \BadMethodCallException implements ExceptionInterface
{
}
