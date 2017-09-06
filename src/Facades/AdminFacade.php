<?php

namespace Sco\Admin\Facades;

use Illuminate\Support\Facades\Facade;

class AdminFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'admin.instance';
    }
}
