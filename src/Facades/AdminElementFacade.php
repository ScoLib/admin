<?php


namespace Sco\Admin\Facades;

use Illuminate\Support\Facades\Facade;
use Sco\Admin\Elements\Text;
use Sco\Admin\Elements\Select;

/**
 * Class AdminFieldFacade
 *
 * @package Sco\Admin\Facades
 *
 * @method static Text text($name, $title)
 * @method static Select select($name, $title)
 */
class AdminElementFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'admin.element.factory';
    }
}
