<?php

namespace Sco\Admin\Config;

use Sco\Admin\Traits\HasAttributes;

abstract class AbstractConfig
{
    use HasAttributes;

    protected $defaultPermissions = [
        'view'   => true,
        'create' => true,
        'update' => true,
        'delete' => true,
    ];

    public function __construct(array $attributes)
    {
        $this->merge($attributes);
        $this->parse();
    }

    protected function parse()
    {
        $this->parsePermission();
    }

    protected function parsePermission()
    {
        $permissions = collect();
        $permission  = $this->getAttribute('permissions');
        if (is_array($permission)) {
            $option = array_merge($this->defaultPermissions, $permission);
            foreach ($option as $key => $item) {
                $val = $item instanceof \Closure ? $item() : $item;
                $permissions->put($key, $val ? true : false);
            }
        } else {
            $val = $permission instanceof \Closure ? $permission() : $permission;
            foreach ($this->defaultPermissions as $key => $item) {
                $permissions->put($key, $val ? true : false);
            }
        }
        $this->setAttribute('permissions', $permissions->toArray());
    }
}
