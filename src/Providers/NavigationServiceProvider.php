<?php

namespace Sco\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use KodiComponents\Navigation\Contracts\NavigationInterface;
use KodiComponents\Navigation\Navigation;
use KodiComponents\Navigation\Contracts\BadgeInterface;
use KodiComponents\Navigation\Contracts\PageInterface;
use Sco\Admin\Navigation\Badge;
use Sco\Admin\Navigation\Page;

class NavigationServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->app->singleton('admin.navigation', function () {
            return new Navigation();
        });

        $this->app->alias('admin.navigation', NavigationInterface::class);

        // overwrite Navigation Page Bind
        $this->app->bind(PageInterface::class, Page::class);
        $this->app->bind(BadgeInterface::class, Badge::class);
    }
}
