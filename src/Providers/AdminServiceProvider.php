<?php

namespace Sco\Admin\Providers;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Laracasts\Utilities\JavaScript\JavaScriptServiceProvider;
use Sco\ActionLog\LaravelServiceProvider;
use Sco\Admin\Admin;
use Sco\Admin\Exceptions\Handler;
use Sco\Admin\Facades\AdminFacade;

/**
 *
 */
class AdminServiceProvider extends ServiceProvider
{
    protected $commands = [
        \Sco\Admin\Console\InstallCommand::class,
    ];

    protected $middlewares = [
        'admin.guest'       => \Sco\Admin\Http\Middleware\RedirectIfAuthenticated::class,
        'admin.permissions' => \Sco\Admin\Http\Middleware\Permissions::class,
        'admin.phptojs'     => \Sco\Admin\Http\Middleware\PHPVarToJavaScript::class,
        'admin.can'         => \Sco\Admin\Http\Middleware\Authorize::class,
        'admin.role'        => \Sco\Admin\Http\Middleware\EntrustRole::class,
    ];

    protected $providers = [
        LaravelServiceProvider::class,
        JavaScriptServiceProvider::class,
        PublishServiceProvider::class,
    ];

    protected $aliases = [
        'Admin' => AdminFacade::class,
        //'AdminConfig' => ConfigFacade::class,
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
        $this->mergeConfigFrom(
            $this->getBasePath() . '/config/admin.php',
            'admin'
        );

        $this->registerExceptionHandler();
        $this->registerAdmin();
        $this->registerAliases();
        $this->registerMiddleware();

        $this->commands($this->commands);

        $this->registerProviders();
    }

    protected function registerMiddleware()
    {
        $router = $this->app['router'];
        foreach ($this->middlewares as $key => $middleware) {
            $router->aliasMiddleware($key, $middleware);
        }

        $router->bind('model', function ($value) {
            return $this->app['admin.instance']->getConfig($value);
        });
    }

    protected function registerAliases()
    {
        AliasLoader::getInstance($this->aliases);
    }

    protected function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
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

    protected function registerAdmin()
    {
        $this->app->instance('admin.instance', new Admin($this->app));
    }
}
