<?php

namespace Sco\Admin\Contracts\View\Extensions;

use Illuminate\Database\Eloquent\Builder;

interface ExtensionInterface
{
    /**
     * Add a extension item.
     *
     * @param $value
     *
     * @return $this
     */
    public function add($value);

    /**
     * Set extension items.
     *
     * @param $values
     *
     * @return $this
     */
    public function set($values);

    /**
     * Wipe item.
     *
     * @return $this
     */
    public function clear();

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return mixed
     */
    public function apply(Builder $query);
}
