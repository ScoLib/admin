<?php

namespace Sco\Admin\View\Extensions;

use Illuminate\Database\Eloquent\Builder;

class Scopes extends Extension
{
    public function add($value)
    {
        if (!is_array($value)) {
            $value = func_get_args();
        }

        $this->push($value);
        return $this;
    }

    public function apply(Builder $query)
    {
        $this->each(function ($scope) use ($query) {

        });
    }
}
