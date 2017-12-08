<?php

namespace Sco\Admin\Form\Elements;

use Illuminate\Database\Eloquent\Model;
use Sco\Admin\Contracts\Form\Elements\ElementInterface;

abstract class Element implements ElementInterface
{
    protected $type;

    protected $name;

    protected $title;

    protected $disabled = false;

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
        $this->setName($name)->setTitle($title);
    }

    public function getType()
    {
        return $this->type;
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

    public function save()
    {
        $this->setModelAttribute(
            $this->getValueFromRequest()
        );
    }

    public function finishSave()
    {
        //
    }

    protected function setModelAttribute($value)
    {
        $model = $this->getModel();
        $model->setAttribute(
            $this->getName(),
            $this->prepareValue($value)
        );
    }

    protected function getValueFromRequest()
    {
        return request()->input($this->getName());
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    protected function prepareValue($value)
    {
        if (is_array($value)) {
            return implode(',', $value);
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getModel()
    {
        return $this->model;
    }

    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->getValueFromModel();
    }

    protected function getValueFromModel()
    {
        $model = $this->getModel();
        $value = $this->getDefaultValue();
        if (is_null($model) || !$model->exists) {
            return $value;
        }
        return $model->getAttribute($this->getName());
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setDefaultValue($value)
    {
        $this->defaultValue = $value;

        return $this;
    }


    protected function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function isDisabled()
    {
        return $this->disabled;
    }

    public function setDisabled()
    {
        $this->disabled = true;

        return $this;
    }

    public function toArray()
    {
        return [
            'name'     => $this->getName(),
            'title'    => $this->getTitle(),
            'type'     => $this->getType(),
            'disabled' => $this->isDisabled(),
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
