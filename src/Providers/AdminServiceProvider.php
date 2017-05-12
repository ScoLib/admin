<?php

namespace Sco\Admin\Providers;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Sco\Admin\Exceptions\Handler;

/**
 *
 */
class AdminServiceProvider extends ServiceProvider
{
    protected $commands = [
        \Sco\Admin\Console\InstallCommand::class
    ];

    protected $middlewares = [
        'auth.admin'        => \Sco\Admin\Http\Middleware\AdminAuthenticate::class,
        'guest.admin'       => \Sco\Admin\Http\Middleware\RedirectIfAuthenticated::class,
        'admin.menu'        => \Sco\Admin\Http\Middleware\AdminMenu::class,
        'admin.permissions' => \Sco\Admin\Http\Middleware\Permissions::class,
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

        $this->registerExceptionHandler();
    }

    protected function registerExceptionHandler()
    {
        $exceptHandler = app(ExceptionHandler::class);
        $this->app->singleton(
            ExceptionHandler::class,
            function () use ($exceptHandler) {
                return new Handler($exceptHandler);
            }
        );
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
        $this->commands($this->commands);

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
            'Entrust' => \Zizaco\Entrust\EntrustFacade::class,
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
