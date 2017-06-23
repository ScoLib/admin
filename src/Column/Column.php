<?php


namespace Sco\Admin\Column;

use Illuminate\Database\Eloquent\Model;
use Sco\Attributes\HasOriginalAndAttributesTrait;
use Sco\Admin\Contracts\Config as ConfigContract;


abstract class Column
{
    use HasOriginalAndAttributesTrait;

    protected $defaultsAttributes = [
        'key'      => '',
        'title'    => '',
        'sortable' => false,
        'width'    => 0,
    ];

    protected $defaults = [];

    protected $configFactory;

    public function __construct($attributes)
    {
        //$this->configFactory = $factory;
        $this->setAttribute(array_merge($this->getDefaults(), $attributes));
    }

    protected function getDefaults()
    {
        return array_merge($this->defaultsAttributes, $this->defaults);
    }

    public function parseData(Model $model)
    {
        return [
            $this->getAttribute('key') => property_exists($this->getAttribute('key'), $model),
        ];
    }

    public function __toString()
    {
        return $this->toJson();
    }
}
