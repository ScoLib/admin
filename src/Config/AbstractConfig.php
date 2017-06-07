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
        $attribute = collect();
        $permissions  = $this->getAttribute('permissions');
        if (is_array($permissions)) {
            $option = array_merge($this->defaultPermissions, $permissions);
            foreach ($option as $key => $item) {
                $val = $item instanceof \Closure ? $item() : $item;
                $attribute->put($key, $val ? true : false);
            }
        } else {
            $val = $permissions instanceof \Closure ? $permissions() : $permissions;
            foreach ($this->defaultPermissions as $key => $item) {
                $attribute->put($key, $val ? true : false);
            }
        }
        $this->setAttribute('permissions', $attribute->toArray());
    }
}
