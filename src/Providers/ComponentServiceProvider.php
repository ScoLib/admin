<?php

namespace Sco\Admin\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Sco\Admin\Component\Component;
use Sco\Admin\Contracts\ComponentInterface;
use Sco\Admin\Contracts\Initializable;
use Sco\Admin\Contracts\WithNavigation;
use Sco\Admin\Exceptions\InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $aliases = $this->app['admin.components']->keyBy(function (ComponentInterface $component) {
            return $component->getName();
        });
        $this->app['router']->bind('model', function ($value, $route) use ($aliases) {
            if (!$aliases->has($value)) {
                throw new NotFoundHttpException('Not Found Model Component');
            }
            return $aliases->get($value);
        });
    }

    protected function registerComponents()
    {
        foreach (config('admin.components', []) as $model => $component) {
            if (!class_exists($component)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Class "%s" does not exist.',
                        $component
                    )
                );
            }

            $class = new $component($this->app, $model);
            if (!($class instanceof ComponentInterface)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Class "%s" must be instanced of "%s".',
                        $component,
                        ComponentInterface::class
                    )
                );
            }

            if ($class instanceof Initializable) {
                $class->initialize();
            }

            if ($class instanceof WithNavigation) {
                $class->addToNavigation();
            }

            $this->app['admin.components']->put($model, $class);
        }
    }
}
