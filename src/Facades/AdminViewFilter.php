<?php

namespace Sco\Admin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Sco\Admin\View\FilterFactory
 */
class AdminViewFilter extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'admin.view.filter.factory';
    }
}
