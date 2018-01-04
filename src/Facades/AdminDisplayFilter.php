<?php

namespace Sco\Admin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Sco\Admin\Display\FilterFactory
 */
class AdminDisplayFilter extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'admin.display.filter.factory';
    }
}
