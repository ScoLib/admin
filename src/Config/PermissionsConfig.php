<?php


namespace Sco\Admin\Config;

use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Sco\Attributes\HasAttributesTrait;

class PermissionsConfig implements Arrayable, Jsonable, JsonSerializable
{
    use HasAttributesTrait;

    protected $default = [
        'view'   => true,
        'create' => true,
        'edit'   => true,
        'delete' => true,
    ];

    public function __construct($config)
    {
        $this->compile($config);
    }

    protected function compile($config)
    {
        if (is_array($config)) {
            $config = array_merge($this->default, $config);
            foreach ($config as $key => $item) {
                $val = $item instanceof \Closure ? $item() : $item;
                $this->setAttribute($key, $val ? true : false);
            }
        } else {
            $val = $config instanceof \Closure ? $config() : $config;
            foreach ($this->default as $key => $item) {
                $this->setAttribute($key, $val ? true : false);
            }
        }
    }

    public function isCreatable()
    {
        return $this->getAttribute('create', false);
    }

    public function isViewable()
    {
        return $this->getAttribute('view', false);
    }

    public function isEditable()
    {
        return $this->getAttribute('edit', false);
    }

    public function isDeletable()
    {
        return $this->getAttribute('delete', false);
    }
}
