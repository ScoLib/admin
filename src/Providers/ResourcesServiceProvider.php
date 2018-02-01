<?php

namespace Sco\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class ResourcesServiceProvider extends ServiceProvider
{
    public function getBasePath()
    {
        return dirname(dirname(__DIR__));
    }

    public function boot()
    {
        $this->loadViewsFrom(
            $this->getBasePath() . '/resources/views',
            'admin'
        );

        if ($this->app->runningInConsole()) {
            $this->publishAssets();
            $this->publishConfig();
            $this->publishViews();
        }
    }

    public function register()
    {
    }

    protected function publishAssets()
    {
        $this->publishes([
            $this->getBasePath() . '/resources/assets' => base_path('resources/assets/vendor/admin'),
        ], 'assets');
    }

    protected function publishConfig()
    {
        $this->publishes([
            $this->getBasePath() . '/config/' => config_path(),
        ], 'config');
    }

    protected function publishViews()
    {
        $this->publishes([
            $this->getBasePath() . '/resources/views' => base_path('resources/views/vendor/admin'),
        ], 'views');
    }
}
