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

    public function __construct($name, $title)
    {
        $this->setName($name)->setTitle($title);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return Filter
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     *
     * @return Filter
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function isActive()
    {
        return !is_null($this->value);
    }

    /**
     * Apply filter to the query.
     *
     * @param Builder $query
     */
    public function apply(Builder $query)
    {

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
