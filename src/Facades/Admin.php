<?php

namespace Sco\Admin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Sco\Admin\Admin
 */
class Admin extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'admin.instance';
    }
}
