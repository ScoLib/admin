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

    /**
     * {@inheritdoc}
     */
    public function apply(Builder $query)
    {
        $name = $this->getName();
        if (strpos($name, '.') !== false) {
            list($relation, $name) = explode('.', $name, 2);
            $query->whereHas($relation, function ($q) use ($name) {
                $this->buildQuery($q, $name);
            });
        } else {
            $this->buildQuery($query, $this->getName());
        }
    }

    /**
     * Build the filter query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $name
     */
    protected function buildQuery(Builder $query, $name)
    {
        $op    = $this->getOperator();
        $value = $this->getValue();

        switch ($op) {
            case 'in':
                $query->whereIn($name, (array)$value);
                break;
            case 'between':
                $query->whereBetween($name, (array)$value);
                break;
            case 'like':
                $value .= '%';
                $query->where($name, $op, $value);
                break;
            default:
                $query->where($name, $op, $value);
        }
    }

    protected function getRequestInputValue()
    {
        $name = $this->getRequestName();
        return request()->input($name);
    }

    protected function getRequestName()
    {
        return str_replace('.', '_', $this->getName());
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
