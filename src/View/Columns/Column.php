<?php


namespace Sco\Admin\View\Columns;

use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Sco\Admin\Contracts\ColumnInterface;

abstract class Column implements ColumnInterface, Arrayable, Jsonable, JsonSerializable
{
    protected $name;

    protected $label;

    protected $width = 0;

    protected $minWidth = 80;

    protected $sortable = false;

    protected $fixed = false;

    public function __construct($name, $label)
    {
        $this->name  = $name;
        $this->label = $label;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function setMinWidth($width)
    {
        $this->minWidth = $width;
    }

    public function isSortable()
    {
        $this->sortable = true;
    }

    public function isCustomSortable()
    {
        $this->sortable = 'custom';
        // TODO
        // register sort route
    }

    public function isFixed()
    {
        $this->fixed = true;
    }

    public function toArray()
    {
        return [
            'name'     => $this->getName(),
            'label'    => $this->label,
            'width'    => $this->width,
            'fixed'    => $this->fixed,
            'minWidth' => $this->minWidth,
            'sortable' => $this->sortable,
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    public function __toString()
    {
        return $this->toJson();
    }
}
