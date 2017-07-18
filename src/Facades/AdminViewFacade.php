<?php


namespace Sco\Admin\Facades;

use Illuminate\Support\Facades\Facade;

class AdminViewFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'admin.view.factory';
    }
}
