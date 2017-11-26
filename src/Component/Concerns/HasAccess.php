<?php

namespace Sco\Admin\Component\Concerns;

trait HasAccess
{
    /**
     * @var \Illuminate\Support\Collection
     */
    private static $abilities;

    protected static $observer = \Sco\Admin\Component\Observer::class;

    protected $observables = [];

    public static function bootHasAccess()
    {
        static::$abilities = new Collection();

        static::observe(static::$observer);
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

    public static function observe($class)
    {
        $instance = new static;

        $className = is_string($class) ? $class : get_class($class);

        foreach ($instance->getObservableAbilities() as $ability) {
            if (method_exists($class, $ability)) {
                $instance->registerAccess(
                    $ability,
                    [$instance->app->make($className), $ability]
                );
            }
        }
    }

    /**
     * Get the observable event names.
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

    public function registerAccess($ability, $callback)
    {
        static::$abilities->put($ability, $callback);
    }

    /**
     * @param string $ability
     *
     * @return mixed
     */
    final public function can($ability)
    {
        if (!static::$abilities->has($ability)) {
            return false;
        }
        $value = static::$abilities->get($ability);
        if (is_callable($value)) {
            return call_user_func_array(
                $value,
                [$this]
            );
        }
        return $value ? true : false;
    }
}
