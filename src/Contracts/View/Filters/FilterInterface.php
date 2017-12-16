<?php

namespace Sco\Admin\Contracts\View\Filters;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Builder;
use JsonSerializable;
use Sco\Admin\Contracts\Initializable;

interface FilterInterface extends Arrayable, Jsonable, JsonSerializable, Initializable
{
    /**
     * Is filter active?
     *
     * @return bool
     */
    public function isActive();

    /**
     * Apply filter to the query.
     *
     * @param Builder $query
     */
    public function apply(Builder $query);

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
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title);

    /**
     * @return mixed
     */
    public function getDefaultValue();

    /**
     * @param mixed $defaultValue
     *
     * @return $this
     */
    public function setDefaultValue($defaultValue);

    /**
     * @return string
     */
    public function getOperator();

    /**
     * @param string $operator
     *
     * @return $this
     */
    public function setOperator(string $operator);
}
