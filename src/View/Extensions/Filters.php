<?php

namespace Sco\Admin\View\Extensions;

use Illuminate\Database\Eloquent\Builder;
use Sco\Admin\Contracts\View\Filters\FilterInterface;

class Filters extends Extension
{
    public function add($value)
    {
        if (!($value instanceof FilterInterface)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'filter must be %s',
                    FilterInterface::class
                )
            );
        }

        $this->push($value);
        return $this;
    }

    public function getActive()
    {
        $this->filter(function (FilterInterface $filter) {
            return $filter->isActive();
        });
    }

    public function apply(Builder $query)
    {
        $this->getActive()->each(function (FilterInterface $filter) use ($query) {
            $filter->apply($query);
        });
    }
}
