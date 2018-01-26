<?php

namespace Sco\Admin\Form\Elements;

use Illuminate\Database\Eloquent\Model;
use Sco\Admin\Contracts\Form\Elements\ElementInterface;

/**
 * All Element abstract class
 *
 * @package Sco\Admin\Form\Elements
 */
abstract class Element implements ElementInterface
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var bool
     */
    protected $disabled = false;

    /**
     * @var mixed
     */
    protected $defaultValue;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * @var \Closure
     */
    protected $mutator;

    /**
     * Element constructor.
     *
     * @param string $name
     * @param string $title
     */
    public function __construct(string $name, string $title)
    {
        $this->setName($name)->setTitle($title);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName(string $value)
    {
        $this->name = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle(string $value)
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

    /**
     * @param $value
     */
    protected function setModelAttribute($value)
    {
        $model = $this->getModel();
        $model->setAttribute(
            $this->getName(),
            $this->prepareValue($value)
        );
    }

    /**
     * @return array|string
     */
    protected function getValueFromRequest()
    {
        return request()->input($this->getName());
    }

    /**
     * @return \Closure
     */
    public function getMutator(): \Closure
    {
        return $this->mutator;
    }

    /**
     * @param \Closure $mutator
     * @return $this
     */
    public function setMutator(\Closure $mutator)
    {
        $this->mutator = $mutator;

        return $this;
    }

    public function hasMutator()
    {
        return is_callable($this->getMutator());
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    protected function prepareValue($value)
    {
        if ($this->hasMutator()) {
            $value = call_user_func($this->getMutator(), $value);
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

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return $this
     */
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

    /**
     * @return mixed
     */
    protected function getValueFromModel()
    {
        $model = $this->getModel();
        $value = $this->getDefaultValue();
        if (is_null($model) || ! $model->exists) {
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

    /**
     * @return mixed
     */
    protected function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @return bool
     */
    public function isDisabled()
    {
        return $this->disabled;
    }

    /**
     * @return $this
     */
    public function setDisabled()
    {
        $this->disabled = true;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'name'     => $this->getName(),
            'title'    => $this->getTitle(),
            'type'     => $this->getType(),
            'disabled' => $this->isDisabled(),
        ];
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
