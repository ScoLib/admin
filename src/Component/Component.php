<?php


namespace Sco\Admin\Component;


use Sco\Admin\Component\Concerns\HasEvents;
use Sco\Admin\Contracts\ComponentInterface;

abstract class Component implements ComponentInterface
{
    use HasEvents;

    protected static $dispatcher;

    protected static $booted = [];

    public function __construct()
    {
        $this->bootIfNotBooted();

    }

    protected function bootIfNotBooted()
    {
        if (!isset(static::$booted[static::class])) {
            static::$booted[static::class] = true;

            $this->fireEvent('booting', false);

            static::boot();

            $this->fireEvent('booted', false);
        }
    }

    protected static function boot()
    {
    }
}
