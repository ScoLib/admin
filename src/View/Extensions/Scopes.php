<?php

namespace Sco\Admin\View\Extensions;

use Illuminate\Database\Eloquent\Builder;

class Scopes extends Extension
{
    public function apply(Builder $query)
    {
        $this->each(function ($scope) use ($query) {

        });
    }
}
