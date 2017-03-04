<?php

namespace Sco\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use Zizaco\Entrust\EntrustServiceProvider;

/**
 *
 */
class AdminServiceProvider extends ServiceProvider
{
    protected $commands = [
        \Sco\Admin\Commands\Install::class,
    ];

    protected $middlewares = [
        'auth.admin'  => \Sco\Admin\Http\Middleware\AdminAuthenticate::class,
        'guest.admin' => \Sco\Admin\Http\Middleware\RedirectIfAuthenticated::class,
        'admin.menu'  => \Sco\Admin\Http\Middleware\AdminMenu::class,
    ];

    public function getBasePath()
    {
        return dirname(dirname(__DIR__));
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMiddleware();

        // 后台模板目录
        $this->loadViewsFrom($this->getBasePath() . '/resources/admin',
            'admin');
        // 后台语言包目录
        $this->loadTranslationsFrom($this->getBasePath() . '/resources/lang',
            'Admin');

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom($this->getBasePath() . '/database/migrations');
            $this->publishAdmin();
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        //$this->commands($this->commands);

        $this->mergeConfigFrom($this->getBasePath() . '/config/admin.php',
            'admin');
    }

    protected function registerMiddleware()
    {
        $router = $this->app['router'];
        foreach ($this->middlewares as $key => $middleware) {
            $router->middleware($key, $middleware);
        }
    }

    protected function publishAdmin()
    {
        $this->publishAssets();
        $this->publishConfig();
        $this->publishViews();
        $this->publishTranslations();
    }

    protected function publishAssets()
    {
        $this->publishes([
            $this->getBasePath() . '/resources/assets' => base_path('resources/assets/admin'),
        ], 'assets');
    }

    protected function publishConfig()
    {
        $this->publishes([
            $this->getBasePath() . '/config/admin.php'   => config_path('admin.php'),
            $this->getBasePath() . '/config/entrust.php' => config_path('entrust.php'),
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
}
