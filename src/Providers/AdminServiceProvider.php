<?php

namespace Sco\Admin\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Sco\Admin\Admin;
use Sco\Admin\Contracts\Form\ElementFactoryInterface;
use Sco\Admin\Contracts\Form\FormFactoryInterface;
use Sco\Admin\Contracts\RepositoryInterface;
use Sco\Admin\Contracts\View\ColumnFactoryInterface;
use Sco\Admin\Contracts\View\ViewFactoryInterface;
use Sco\Admin\Form\ElementFactory;
use Sco\Admin\Form\FormFactory;
use Sco\Admin\Repositories\Repository;
use Sco\Admin\View\ColumnFactory;
use Sco\Admin\View\ViewFactory;

class AdminServiceProvider extends ServiceProvider
{
    protected $commands = [
        \Sco\Admin\Console\InstallCommand::class,
    ];

    protected $middlewares = [
        'admin.auth'      => \Sco\Admin\Http\Middleware\Authenticate::class,
        'admin.guest'     => \Sco\Admin\Http\Middleware\RedirectIfAuthenticated::class,
        'admin.can.route' => \Sco\Admin\Http\Middleware\RouteAuthorize::class,
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
        
        $this->registerMiddleware();
        $this->registerFactory();
        $this->app->instance('admin.instance', new Admin($this->app));
        $this->app->bind(RepositoryInterface::class, Repository::class);
        $this->commands($this->commands);
    }

    protected function registerMiddleware()
    {
        foreach ($this->middlewares as $key => $middleware) {
            $this->app['router']->aliasMiddleware($key, $middleware);
        }
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
