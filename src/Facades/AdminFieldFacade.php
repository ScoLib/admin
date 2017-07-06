<?php


namespace Sco\Admin\Facades;


use Illuminate\Support\Facades\Facade;

class AdminFieldFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'admin.field.factory';
    }
}
