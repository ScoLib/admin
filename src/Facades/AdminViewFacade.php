<?php


namespace Sco\Admin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Sco\Admin\View\ViewFactory
 */
class AdminViewFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'admin.view.factory';
    }
}
