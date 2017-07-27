<?php


namespace Sco\Admin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Sco\Admin\View\Table table()
 */
class AdminViewFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'admin.view.factory';
    }
}