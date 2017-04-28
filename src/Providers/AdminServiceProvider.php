<?php

namespace Sco\Admin\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

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

        // 路由文件
        $this->loadRoutes();

        // 后台模板目录
        $this->loadViewsFrom(
            $this->getBasePath() . '/resources/views',
            'admin'
        );
        // 后台语言包目录
        $this->loadTranslationsFrom(
            $this->getBasePath() . '/resources/lang',
            'admin'
        );

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom($this->getBasePath() . '/database/migrations');
            $this->publishAdmin();
        }
    }

    protected function registerMiddleware()
    {
        $router = $this->app['router'];
        foreach ($this->middlewares as $key => $middleware) {
            $router->aliasMiddleware($key, $middleware);
        }
    }

    protected function loadRoutes()
    {
        $routesFile = $this->getBasePath() . '/routes/admin.php';
        if (file_exists(base_path('routes/admin.php'))) {
            $routesFile = base_path('routes/admin.php');
        }

        $this->loadRoutesFrom($routesFile);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->commands($this->commands);

        $this->mergeConfigFrom(
            $this->getBasePath() . '/config/admin.php',
            'admin'
        );

        $this->registerProviders();
    }

    protected function registerProviders()
    {
        $this->app->register(\Zizaco\Entrust\EntrustServiceProvider::class);
        $this->app->register(\Sco\ActionLog\LaravelServiceProvider::class);

        AliasLoader::getInstance([
            'Entrust'   => \Zizaco\Entrust\EntrustFacade::class,
            'ActionLog' => \Sco\ActionLog\Facade::class,
        ])->register();
    }

    protected function publishAdmin()
    {
        $this->publishAssets();
        $this->publishConfig();
        $this->publishViews();
        $this->publishTranslations();
        $this->publishRoutes();
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

    protected function publishRoutes()
    {
        $this->publishes([
            $this->getBasePath() . '/routes/admin.php' => base_path('routes/admin.php'),
        ], 'routes');
    }
}
