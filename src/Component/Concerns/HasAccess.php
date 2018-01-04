<?php

namespace Sco\Admin\Component\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait HasAccess
{
    /**
     * The abilities of access.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $abilities;

    /**
     * Access observer class.
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

    /**
     * Initialize access.
     */
    public function bootHasAccess()
    {
        $this->abilities = new Collection();

        $this->observe($this->observer);
    }

    /**
     * Determine if the entity have access to display.
     *
     * @return bool
     */
    public function isDisplay()
    {
        return method_exists($this, 'callDisplay') && $this->can('display');
    }

    /**
     * Check if the entity have access to create.
     *
     * @return bool
     */
    public function isCreate()
    {
        return method_exists($this, 'callCreate') && $this->can('create');
    }

    /**
     * Check if the entity have access to edit.
     *
     * @return bool
     */
    public function isEdit()
    {
        return method_exists($this, 'callEdit') && $this->can('edit');
    }

    /**
     * Check if the entity have access to delete.
     *
     * @return mixed
     */
    public function isDelete()
    {
        return $this->can('delete');
    }

    /**
     * Check if the entity have access to destroy.
     *
     * @return bool
     */
    public function isDestroy()
    {
        return $this->isRestorableModel() && $this->can('destroy');
    }

    /**
     * Check if the entity have access to restore.
     *
     * @return bool
     */
    public function isRestore()
    {
        return $this->isRestorableModel() && $this->can('restore');
    }

    /**
     * Whether the model can be restored
     *
     * @return mixed
     */
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
                $this->registerAbility($ability, $className . '@' . $ability);
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
        return array_merge([
            'display',
            'create',
            'edit',
            'delete',
            'destroy',
            'restore',
        ], $this->observables);
    }

    /**
     * register ability to access.
     *
     * @param string $ability
     * @param string|\Closure $callback
     */
    public function registerAbility($ability, $callback)
    {
        $this->abilities->put($ability, $this->makeAbilityCallback($callback));
    }

    /**
     * @param string|\Closure $callback
     *
     * @return \Closure
     */
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
     * Determine if the entity has a given ability.
     *
     * @param string $ability
     *
     * @return bool
     */
    final public function can($ability)
    {
        if (! $this->abilities->has($ability)) {
            return false;
        }
        $value = $this->abilities->get($ability);

        return $value($this) ? true : false;
    }

    /**
     * Get all ability.
     *
     * @return Collection
     */
    public function getAccesses()
    {
        return $this->abilities->mapWithKeys(function ($item, $key) {
            return [$key => $this->can($key)];
        });
    }
}
