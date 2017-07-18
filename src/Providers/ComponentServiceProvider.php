<?php

namespace Sco\Admin\Providers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Sco\Admin\Component\Component;

class ComponentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Component::setEventDispatcher($this->app['events']);

        $this->registerComponents();

        $this->bindRouteModel();
    }

    public function register()
    {
        $this->app->instance('admin.components', new Collection());
    }

    protected function bindRouteModel()
    {
        $this->app['router']->bind('model', function ($value, $route) {
            if (!$this->app['admin.components']->has($value)) {
                throw new ModelNotFoundException();
            }
            return $this->app['admin.components']->get($value);
        });
    }

    protected function registerComponents()
    {
        foreach (config('admin.components', []) as $model => $component) {
            $class = new $component($this->app, $model);
            $this->app['admin.components']->put($class->getName(), $class);
        }
    }
}
