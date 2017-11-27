<?php

namespace Sco\Admin\Component\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait HasAccess
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $abilities;

    /**
     * Access observer class
     *
     * @var string
     */
    protected $observer = \Sco\Admin\Component\Observer::class;

    /**
     * User exposed observable abilities.
     *
     * @var array
     */
    protected $observables = [];

    public function bootHasAccess()
    {
        $this->abilities = new Collection();

        $this->observe($this->observer);
    }

    public function isView()
    {
        return method_exists($this, 'callView') && $this->can('view');
    }

    public function isCreate()
    {
        return method_exists($this, 'callCreate') && $this->can('create');
    }

    public function isEdit()
    {
        return method_exists($this, 'callEdit') && $this->can('edit');
    }

    public function isDelete()
    {
        return $this->can('delete');
    }

    public function isDestroy()
    {
        return $this->isRestorableModel() && $this->can('destroy');
    }

    public function isRestore()
    {
        return $this->isRestorableModel() && $this->can('restore');
    }

    protected function isRestorableModel()
    {
        return $this->getRepository()->isRestorable();
    }

    /**
     * Register an observer with the Component.
     *
     * @param $class
     */
    public function observe($class)
    {
        $className = is_string($class) ? $class : get_class($class);

        foreach ($this->getObservableAbilities() as $ability) {
            if (method_exists($class, $ability)) {
                $this->registerAbility(
                    $ability,
                    $className . '@' . $ability
                );
            }
        }
    }

    /**
     * Get the observable ability names.
     *
     * @return array
     */
    public function getObservableAbilities()
    {
        return array_merge(
            [
                'view', 'create', 'edit', 'delete',
                'destroy', 'restore',
            ],
            $this->observables
        );
    }

    public function registerAbility($ability, $callback)
    {
        $this->abilities->put($ability, $this->makeAbilityCallback($callback));
    }

    protected function makeAbilityCallback($callback)
    {
        return function ($component) use ($callback) {
            if (is_callable($callback)) {
                return $callback($component);
            }
            if (is_string($callback)) {
                list($class, $method) = Str::parseCallback($callback);
                return call_user_func([$this->app->make($class), $method], $component);
            }
        };
    }

    /**
     * @param string $ability
     *
     * @return mixed
     */
    final public function can($ability)
    {
        if (!$this->abilities->has($ability)) {
            return false;
        }
        $value = $this->abilities->get($ability);

        return $value($this) ? true : false;
    }

    public function getAccesses()
    {
        return $this->abilities->mapWithKeys(function ($item, $key) {
            return [$key => $this->can($key)];
        });
    }
}
