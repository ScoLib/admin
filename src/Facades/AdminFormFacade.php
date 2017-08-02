<?php


namespace Sco\Admin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Sco\Admin\Form\FormFactory
 */
class AdminFormFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'admin.form.factory';
    }
}
