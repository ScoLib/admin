<?php


namespace Sco\Admin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Sco\Admin\Form\ElementFactory
 */
class AdminElement extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'admin.element.factory';
    }
}
