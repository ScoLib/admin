<?php

namespace Sco\Admin\Config;

use Sco\Attributes\HasAttributesTrait;

abstract class Config implements ConfigInterface
{
    use HasAttributesTrait;

    protected $original = [];

    protected $defaultPermissions = [
        'view'   => true,
        'create' => true,
        'update' => true,
        'delete' => true,
    ];

    public function __construct(array $original)
    {
        $this->original = $original;
        $this->parse();
    }

    protected function parse()
    {
        $this->setAttribute('title', $this->original['title']);
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

    public function getOption($key, $default = null)
    {
        return $this->getAttribute($key, $default);
    }

    public function __toString()
    {
        return $this->toJson();
    }
}
