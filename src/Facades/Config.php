<?php

namespace Sco\Admin\Facades;

use Illuminate\Support\Facades\Facade;

class Config extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'admin.config.factory';
    }
}
