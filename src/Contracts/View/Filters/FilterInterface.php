<?php

namespace Sco\Admin\Contracts\View\Filters;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{

    /**
     * Is filter active?
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
