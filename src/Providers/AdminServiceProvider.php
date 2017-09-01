<?php

namespace Sco\Admin\Providers;

use Carbon\Carbon;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Laracasts\Utilities\JavaScript\JavaScriptServiceProvider;
use Sco\Admin\Contracts\Form\ElementFactoryInterface;
use Sco\Admin\Contracts\Form\FormFactoryInterface;
use Sco\Admin\Contracts\RepositoryInterface;
use Sco\Admin\Contracts\View\ColumnFactoryInterface;
use Sco\Admin\Contracts\View\ViewFactoryInterface;
use Sco\Admin\Facades\AdminFormFacade;
use Sco\Admin\Form\ElementFactory;
use Sco\Admin\Exceptions\Handler;
use Sco\Admin\Facades\AdminColumnFacade;
use Sco\Admin\Facades\AdminElementFacade;
use Sco\Admin\Facades\AdminNavigationFacade;
use Sco\Admin\Facades\AdminViewFacade;
use Sco\Admin\Form\FormFactory;
use Sco\Admin\Repositories\Repository;
use Sco\Admin\View\ColumnFactory;
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
    ];

    protected $providers = [
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
        $this->registerFactory();
        $this->registerProviders();
        $this->app->bind(RepositoryInterface::class, Repository::class);
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
            'AdminNavigation' => AdminNavigationFacade::class,

            'AdminView'   => AdminViewFacade::class,
            'AdminColumn' => AdminColumnFacade::class,

            'AdminForm'    => AdminFormFacade::class,
            'AdminElement' => AdminElementFacade::class,

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

    protected function registerFactory()
    {
        $this->app->singleton('admin.form.factory', function () {
            return new FormFactory($this->app);
        });
        $this->app->alias('admin.form.factory', FormFactoryInterface::class);

        $this->app->singleton('admin.element.factory', function () {
            return new ElementFactory($this->app);
        });
        $this->app->alias('admin.element.factory', ElementFactoryInterface::class);


        $this->app->singleton('admin.view.factory', function () {
            return new ViewFactory();
        });
        $this->app->alias('admin.view.factory', ViewFactoryInterface::class);

        $this->app->singleton('admin.column.factory', function () {
            return new ColumnFactory();
        });
        $this->app->alias('admin.column.factory', ColumnFactoryInterface::class);
    }
}
