<?php


namespace Sco\Admin\Column;

use Sco\Attributes\HasOriginalAndAttributesTrait;

abstract class Column
{
    use HasOriginalAndAttributesTrait;

    protected $defaultsAttributes = [
        'key'      => '',
        'title'    => '',
        //'sortable' => false,
        //'width'    => 0,
    ];

    protected $defaults = [];

    public function __construct($attributes)
    {
        $this->setAttribute(array_merge($this->getDefaults(), $attributes));
    }

    protected function getDefaults()
    {
        return array_merge($this->defaultsAttributes, $this->defaults);
    }

    function __toString()
    {
        return $this->toJson();
    }
}
