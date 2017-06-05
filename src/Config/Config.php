<?php


namespace Sco\Admin\Config;


use Sco\Admin\Traits\HasAttributes;

class Config
{
    use HasAttributes;

    protected $default = [
        'title'      => '',
        'permission' => true,
    ];

    public function __construct(array $attributes)
    {
        $this->attributes = $this->merge($this->default, $attributes);
        $this->parse();
    }

    protected function parse()
    {
        $permission = $this->getAttribute('permission');
        if ($permission instanceof \Closure) {
            $permission = $permission();
        }
        $this->setAttribute('permission', $permission ? true : false);
    }

}