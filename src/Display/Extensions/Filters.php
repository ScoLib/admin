<?php

namespace Sco\Admin\Display\Extensions;

use Illuminate\Database\Eloquent\Builder;
use Sco\Admin\Contracts\Display\Filters\FilterInterface;

class Filters extends Extension
{
    public function add($value)
    {
        if (! ($value instanceof FilterInterface)) {
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

    /**
     *
     * @return \Illuminate\Support\Collection
     */
    public function getActive()
    {
        return $this->filter(function (FilterInterface $filter) {
            return $filter->isActive();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function apply(Builder $query)
    {
        $this->getActive()->each(function (FilterInterface $filter) use ($query) {
            $filter->apply($query);
        });
    }

    public function getDisplayValues()
    {
        return $this->mapWithKeys(function (FilterInterface $filter) {
            return [
                $filter->getName() => $filter->getDisplayValue(),
            ];
        });
    }
}
