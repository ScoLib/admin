<?php

namespace Sco\Admin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \KodiComponents\Navigation\Navigation
 */
class AdminNavigation extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'admin.navigation';
    }
}
