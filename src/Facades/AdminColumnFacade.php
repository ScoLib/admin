<?php


namespace Sco\Admin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Sco\Admin\View\Columns\ColumnFactory
 */
class AdminColumnFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'admin.column.factory';
    }
}
