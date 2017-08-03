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
     * @var mixed
     */
    protected $defaultValue;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function __construct($name, $title)
    {
        $this->name  = $name;
        $this->title = $title;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($value)
    {
        $this->name = $value;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($value)
    {
        $this->title = $value;

        return $this;
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

    public function getValue()
    {
        return $this->getModelValue();
    }

    protected function getModelValue()
    {
        $model = $this->getModel();
        $value = $this->getDefaultValue();
        if (is_null($model) || !$model->exists) {
            return $value;
        }

        $relations = explode('.', $this->getName(), 2);
        $count = count($relations);

        if ($count == 1) {
            return $model->getAttribute($this->getName());
        }

        foreach ($relations as $relation) {
            if ($model->{$relation} instanceof Model) {
                $model = $model->{$relation};
                continue;
            }

            return $model->getAttribute($relation);
        }
    }

    protected function getDefaultValue()
    {
        return $this->defaultValue;
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
