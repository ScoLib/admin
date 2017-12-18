<?php

namespace Sco\Admin\View\Filters;

use Illuminate\Database\Eloquent\Builder;
use Sco\Admin\Contracts\View\Filters\FilterInterface;

abstract class Filter implements FilterInterface
{
    protected $type;

    protected $value;

    protected $name;

    protected $title;

    protected $defaultValue;

    protected $operator = '=';

    /**
     * Apply filter to the query.
     *
     * @param Builder $query
     */
    public function apply(Builder $query)
    {
        $query->where($this->getName(), $this->getOperator(), $this->getValue() . '%');
    }

    public function __construct($name, $title)
    {
        $this->setName($name)->setTitle($title);
    }

    public function initialize()
    {
        if (is_null($value = $this->getValue())) {
            $value = $this->getRequestInputValue();
        }

        $this->setValue($value);
    }

    protected function getRequestInputValue()
    {
        $name = $this->getName();
        return request()->input($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function getViewValue()
    {
        $value = $this->getValue();
        if (is_null($value)) {
            return $this->getDefaultValue();
        }
        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

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
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * {@inheritdoc}
     */
    public function setOperator(string $operator)
    {
        $this->operator = $operator;

        return $this;
    }

    public function isActive()
    {
        return !is_null($this->value);
    }

    public function toArray()
    {
        return [
            'name'  => $this->getName(),
            'title' => $this->getTitle(),
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
