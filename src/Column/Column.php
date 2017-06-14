<?php


namespace Sco\Admin\Column;

use Sco\Attributes\HasOriginalAndAttributesTrait;

abstract class Column
{
    use HasOriginalAndAttributesTrait;

    protected $defaultsOptions = [
        'key'      => '',
        'title'    => '',
        'sortable' => true,
        'width'    => 0,
    ];

    protected $defaults = [];

    public function __construct($options)
    {
        $this->setOriginal(array_merge($this->getDefaults(), $options));
    }

    protected function getDefaults()
    {
        return array_merge($this->defaultsOptions, $this->defaults);
    }

    function __toString()
    {
        return $this->toJson();
    }
}
