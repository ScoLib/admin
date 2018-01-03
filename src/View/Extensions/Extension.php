<?php

namespace Sco\Admin\View\Extensions;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Sco\Admin\Contracts\View\Extensions\ExtensionInterface;

abstract class Extension extends Collection implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    abstract public function add($value);

    /**
     * {@inheritdoc}
     */
    abstract public function apply(Builder $query);

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->items = [];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function set($values)
    {
        $this->clear();

        if (! is_array($values)) {
            $values = func_get_args();
        }

        foreach ($values as $value) {
            $this->add($value);
        }

        return $this;
    }
}
