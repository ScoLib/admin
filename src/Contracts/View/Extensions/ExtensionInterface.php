<?php

namespace Sco\Admin\Contracts\View\Extensions;

use Illuminate\Database\Eloquent\Builder;

interface ExtensionInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return mixed
     */
    public function apply(Builder $query);
}
