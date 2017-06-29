<?php


namespace Sco\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class PublishServiceProvider extends ServiceProvider
{
    public function getBasePath()
    {
        return dirname(dirname(__DIR__));
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishAssets();
            $this->publishConfig();
            $this->publishViews();
            $this->publishTranslations();
            //$this->publishRoutes();
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

    protected function publishTranslations()
    {
        $this->publishes([
            $this->getBasePath() . '/resources/lang' => base_path('resources/lang/vendor/admin'),
        ], 'lang');
    }

    protected function publishRoutes()
    {
        $this->publishes([
            $this->getBasePath() . '/routes/admin.php' => base_path('routes/admin.php'),
        ], 'routes');
    }
}
