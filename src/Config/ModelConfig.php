<?php

namespace Sco\Admin\Config;

class ModelConfig extends Config implements ConfigInterface
{
    protected $attributes = [
        'title'       => '',
        'permissions' => true,
    ];
}
