<?php


namespace Sco\Admin\Fields;

use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Sco\Admin\Contracts\Field as FieldContract;

abstract class Field implements FieldContract, Arrayable, Jsonable, JsonSerializable
{
    protected $type;

    protected $name;
    protected $title;

    public function __construct($name, $title)
    {
        $this->name  = $name;
        $this->title = $title;
    }

    public function isRelationship()
    {
        return !empty($this->relationship);
    }

    public function toArray()
    {
        return [
            'key'   => $this->name,
            'title' => $this->title,
            'type'  => $this->type,
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
