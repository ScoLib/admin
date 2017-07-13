<?php

namespace Sco\Admin\Providers;

use Carbon\Carbon;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use KodiComponents\Navigation\Contracts\BadgeInterface;
use KodiComponents\Navigation\Contracts\NavigationInterface;
use KodiComponents\Navigation\Contracts\PageInterface;
use KodiComponents\Navigation\Navigation;
use KodiComponents\Navigation\NavigationServiceProvider;
use Laracasts\Utilities\JavaScript\JavaScriptServiceProvider;
use Sco\ActionLog\LaravelServiceProvider;
use Sco\Admin\Admin;
use Sco\Admin\Component\Component;
use Sco\Admin\Config\ConfigFactory;
use Sco\Admin\Contracts\ConfigFactoryInterface;
use Sco\Admin\Contracts\RepositoryInterface;
use Sco\Admin\Elements\ElementFactory;
use Sco\Admin\Exceptions\Handler;
use Sco\Admin\Facades\AdminFacade;
use Sco\Admin\Facades\AdminElementFacade;
use Sco\Admin\Facades\AdminNavigationFacade;
use Sco\Admin\Navigation\Badge;
use Sco\Admin\Navigation\Page;
use Sco\Admin\Repositories\Repository;

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
        PublishServiceProvider::class,
        //NavigationServiceProvider::class,
    ];

    protected $aliases = [
        'Admin'           => AdminFacade::class,
        'AdminElement'    => AdminElementFacade::class,
        'AdminNavigation' => AdminNavigationFacade::class,
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
        Component::setEventDispatcher($this->app['events']);

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

        $this->app->call([$this, 'registerNavigation']);
    }

    protected function loadRoutes()
    {
        $routesFile = $this->getBasePath() . '/routes/admin.php';
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
        $this->bindRouteModel();
        $this->registerProviders();
        $this->registerCoreContainerAliases();


        $this->app->bind(RepositoryInterface::class, Repository::class);
        $this->app->singleton(ConfigFactoryInterface::class, function () {
            return new ConfigFactory($this->app);
        });
        $this->app->singleton('admin.element.factory', function () {
            return new ElementFactory($this->app);
        });

        $this->app->singleton('admin.navigation', function () {
            return new Navigation();
        });
        // overwrite Navigation Page Bind
        $this->app->bind(PageInterface::class, Page::class);
        $this->app->bind(BadgeInterface::class, Badge::class);

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

    protected function bindRouteModel()
    {
        $this->app['router']->bind('model', function ($value) {
            return $this->app[ConfigFactoryInterface::class]->make($value)->getModel();
        });
    }

    protected function registerCoreContainerAliases()
    {
        $aliases = [
            'admin.navigation' => [Navigation::class, NavigationInterface::class],
        ];

        foreach ($aliases as $key => $aliases) {
            foreach ($aliases as $alias) {
                $this->app->alias($key, $alias);
            }
        }
    }

    /**
     * @param NavigationInterface $navigation
     */
    public function registerNavigation(NavigationInterface $navigation)
    {
        require $this->getBasePath() . '/src/navigation.php';
    }
}
