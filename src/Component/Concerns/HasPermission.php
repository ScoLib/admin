<?php


namespace Sco\Admin\Component\Concerns;


trait HasPermission
{
    protected $permObserve;

    protected $permissions;

    protected $permMethods = [
        'view', 'create', 'edit',
        'delete', 'destroy', 'restore',
    ];

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

    public function isRestorableModel()
    {
        $this->getRepository()->isRestorable();
    }

    public static function bootHasPermission()
    {
        $instance = new static;

        $instance->initPermissions();
        if ($instance->permObserve) {
            $instance->registerObserver($instance->permObserve);
        }
    }

    public function initPermissions()
    {
        foreach ($this->permMethods as $method) {
            $this->registerPermission($method, true);
        }
    }

    public function registerObserver($class = null)
    {
        if (!$class) {
            return;
        }

        $className = is_string($class) ? $class : get_class($class);

        foreach ($this->permMethods as $method) {
            if (method_exists($class, $method)) {
                $this->registerPermission($method, [$className, $method]);
            }
        }
    }

    public function registerPermission($permission, $callback)
    {
        $this->permissions[$permission] = $callback;
    }

    public function can($permission)
    {
        if (!isset($this->permissions[$permission])) {
            return false;
        }
        if (is_callable($this->permissions[$permission])) {
            return call_user_func_array($this->permissions[$permission], $this);
        } else {
            return $this->permissions[$permission] ? true : false;
        }
    }

    public function getPermissions()
    {
        $data = collect();
        foreach ($this->permMethods as $perm) {
            $method = 'is' . ucfirst($perm);
            if (!method_exists($this, $method)) {
                $method = 'can';
            }

            $data->put($perm, $this->{$method}($perm));
        }
        return $data;
    }
}
