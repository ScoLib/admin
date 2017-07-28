<?php


namespace Sco\Admin\Facades;

use Illuminate\Support\Facades\Facade;
use Sco\Admin\Elements\Text;
use Sco\Admin\Elements\Select;

/**
 * @mixin \Sco\Admin\Form\ElementFactory
 */
class AdminElementFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'admin.element.factory';
    }
}
