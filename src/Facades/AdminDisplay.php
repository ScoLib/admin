<?php

namespace Sco\Admin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Sco\Admin\Display\DisplayFactory
 */
class AdminDisplay extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'admin.display.factory';
    }
}
