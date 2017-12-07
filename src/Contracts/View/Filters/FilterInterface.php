<?php

namespace Sco\Admin\Contracts\View\Filters;

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
     * Apply filter to the query.
     *
     * @param Builder $query
     */
    public function apply(Builder $query);
}
