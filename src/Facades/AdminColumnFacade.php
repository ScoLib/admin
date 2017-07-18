<?php


namespace Sco\Admin\Facades;

use Illuminate\Support\Facades\Facade;

class AdminColumnFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'admin.column.factory';
    }
}
