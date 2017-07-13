<?php


namespace Sco\Admin\Facades;

use Illuminate\Support\Facades\Facade;

class AdminNavigationFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'admin.navigation';
    }
}
