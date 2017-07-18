<?php


namespace Sco\Admin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Sco\Admin\View\Columns\Text text($name, $label)
 * @method static \Sco\Admin\View\Columns\DateTime datetime($name, $label)
 * @method static \Sco\Admin\View\Columns\Image image($name, $label)
 * @method static \Sco\Admin\View\Columns\Link link($name, $label)
 * @method static \Sco\Admin\View\Columns\Custom custom($name, $label)
 */
class AdminColumnFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'admin.column.factory';
    }
}
