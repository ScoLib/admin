<?php

namespace Sco\Admin\Contracts\Display\Filters;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Builder;
use JsonSerializable;

interface FilterInterface extends Arrayable, Jsonable, JsonSerializable
{
    /**
     * Is filter active?
     *
     * @return bool
     */
    public function isActive();

    /**
     * Apply the filter to a given Eloquent query builder.
     *
     * @param Builder $query
     */
    public function apply(Builder $query);

    /**
     * Get display filter form value
     *
     * @return mixed
     */
    public function getDisplayValue();

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue($value);

    /**
     * Get the filter name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set the filter name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name);

    /**
     * Get the filter display name.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set the filter display name.
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title);

    /**
     * Get the filter default name.
     *
     * @return mixed
     */
    public function getDefaultValue();

    /**
     * Set the filter default name.
     *
     * @param mixed $defaultValue
     *
     * @return $this
     */
    public function setDefaultValue($defaultValue);

    /**
     * Get query clause operator.
     *
     * @return string
     */
    public function getOperator();

    /**
     * Set query clause operator.
     *
     * @param string $operator
     *
     * @return $this
     */
    public function setOperator(string $operator);
}
