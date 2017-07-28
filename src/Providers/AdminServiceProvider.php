<?php

namespace Sco\Admin\Providers;

use Carbon\Carbon;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Laracasts\Utilities\JavaScript\JavaScriptServiceProvider;
use Sco\ActionLog\LaravelServiceProvider;
use Sco\Admin\Admin;
use Sco\Admin\Config\ConfigFactory;
use Sco\Admin\Contracts\ColumnFactoryInterface;
use Sco\Admin\Contracts\ConfigFactoryInterface;
use Sco\Admin\Contracts\RepositoryInterface;
use Sco\Admin\Contracts\ViewFactoryInterface;
use Sco\Admin\Form\Elements\ElementFactory;
use Sco\Admin\Exceptions\Handler;
use Sco\Admin\Facades\AdminColumnFacade;
use Sco\Admin\Facades\AdminElementFacade;
use Sco\Admin\Facades\AdminNavigationFacade;
use Sco\Admin\Facades\AdminViewFacade;
use Sco\Admin\Form\FormFactory;
use Sco\Admin\Repositories\Repository;
use Sco\Admin\View\Columns\ColumnFactory;
use Sco\Admin\View\ViewFactory;

/**
 *
 */
class AdminServiceProvider extends ServiceProvider
{
    protected $commands = [
        \Sco\Admin\Console\InstallCommand::class,
    ];

    protected $middlewares = [
        'admin.guest'     => \Sco\Admin\Http\Middleware\RedirectIfAuthenticated::class,
        'admin.phptojs'   => \Sco\Admin\Http\Middleware\PHPVarToJavaScript::class,
        'admin.can.route' => \Sco\Admin\Http\Middleware\RouteAuthorize::class,
        'admin.can.model' => \Sco\Admin\Http\Middleware\ModelAuthorize::class,
    ];

    protected $providers = [
        LaravelServiceProvider::class,
        JavaScriptServiceProvider::class,
        ResourcesServiceProvider::class,
        NavigationServiceProvider::class,
        ComponentServiceProvider::class,
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
        Carbon::setLocale($this->app['config']->get('app.locale'));

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom($this->getBasePath() . '/database/migrations');
        }
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
        $this->registerAliases();
        $this->registerMiddleware();

        $this->app->bind(RepositoryInterface::class, Repository::class);
        $this->app->singleton(ConfigFactoryInterface::class, function () {
            return new ConfigFactory($this->app);
        });

        $this->registerFactory();

        $this->registerProviders();
        $this->registerCoreContainerAliases();
        $this->commands($this->commands);
    }

    protected function registerMiddleware()
    {
        foreach ($this->middlewares as $key => $middleware) {
            $this->app['router']->aliasMiddleware($key, $middleware);
        }
    }

    protected function registerAliases()
    {
        AliasLoader::getInstance([
            'AdminElement'    => AdminElementFacade::class,
            'AdminNavigation' => AdminNavigationFacade::class,
            'AdminColumn'     => AdminColumnFacade::class,
            'AdminView'       => AdminViewFacade::class,
        ]);
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

    protected function registerCoreContainerAliases()
    {
        $aliases = [
            'admin.column.factory' => [
                ColumnFactory::class, ColumnFactoryInterface::class,
            ],
            'admin.view.factory'   => [
                ViewFactory::class, ViewFactoryInterface::class,
            ],
        ];

        foreach ($aliases as $key => $aliases) {
            foreach ($aliases as $alias) {
                $this->app->alias($key, $alias);
            }
        }
    }

    protected function registerFactory()
    {
        $this->app->singleton('admin.form.factory', function () {
            return new FormFactory($this->app);
        });

        $this->app->singleton('admin.element.factory', function () {
            return new ElementFactory($this->app);
        });

        $this->app->singleton('admin.view.factory', function () {
            return new ViewFactory();
        });

        $this->app->singleton('admin.column.factory', function () {
            return new ColumnFactory();
        });
    }
}
