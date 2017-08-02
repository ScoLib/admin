<?php


namespace Sco\Admin\Form\Elements;

use Illuminate\Database\Eloquent\Model;
use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Sco\Admin\Contracts\Form\Elements\ElementInterface;
use Sco\Admin\Contracts\WithModel;

abstract class Element implements
    ElementInterface,
    WithModel,
    Arrayable,
    Jsonable,
    JsonSerializable
{
    protected $type;

    protected $name;
    protected $title;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function __construct($name, $title)
    {
        $this->name  = $name;
        $this->title = $title;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
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
