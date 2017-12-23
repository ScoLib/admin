<?php

namespace Sco\Admin\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Sco\Admin\Component\Component;
use Sco\Admin\Contracts\ComponentInterface;
use Sco\Admin\Contracts\Initializable;
use Sco\Admin\Contracts\WithNavigation;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ComponentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Component::setEventDispatcher($this->app['events']);

        $this->loadComponents(config('admin.components'));

        $this->bindRouteModel();
    }

    public function register()
    {
        $this->app->instance('admin.components', new Collection());
    }

    protected function registerInstanceComponent(ComponentInterface $component)
    {
        $this->app->instance('admin.instance.component', $component);
    }

    protected function bindRouteModel()
    {
        $aliases = $this->app['admin.components']
            ->keyBy(function (ComponentInterface $component) {
                return $component->getName();
            });

        $this->app['router']->bind('model', function ($value, $route) use ($aliases) {
            if (!$aliases->has($value)) {
                throw new NotFoundHttpException(
                    sprintf(
                        'Not Found model(%s) component.',
                        $value
                    )
                );
            }

            $this->registerInstanceComponent(($component = $aliases->get($value)));

            return $component;
        });
    }

    /**
     * load component class from the paths
     *
     * @param mixed $paths
     */
    protected function loadComponents($paths)
    {
        $paths = array_unique(is_array($paths) ? $paths : (array)$paths);

        $paths = array_filter($paths, function ($path) {
            return is_dir($path);
        });

        if (empty($paths)) {
            return;
        }

        $namespace = $this->app->getNamespace();

        foreach ((new Finder())->in($paths)->files() as $file) {
            $class = $namespace . str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after(realpath($file->getPathname()),
                        app_path() . DIRECTORY_SEPARATOR)
                );

            if (is_subclass_of($class, Component::class)
                && !(new \ReflectionClass($class))->isAbstract()) {
                $this->registerComponent($class);
            }
        }
    }

    /**
     * register the component class
     *
     * @param string $class
     */
    protected function registerComponent($class)
    {
        $component = $this->app->make($class);
        if (!($component instanceof ComponentInterface)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Class "%s" must be instanced of "%s".',
                    $component,
                    ComponentInterface::class
                )
            );
        }

        if ($component instanceof Initializable) {
            $component->initialize();
        }

        if ($component instanceof WithNavigation) {
            $component->addToNavigation();
        }

        $this->app['admin.components']->put($component->getName(), $component);
    }
}
