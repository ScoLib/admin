<?php

namespace Sco\Admin\Contracts\View\Extensions;

use Illuminate\Database\Eloquent\Builder;

interface ExtensionInterface
{
    /**
     * @param $values
     *
     * @return $this
     */
    public function set($values);

    /**
     * @param $value
     *
     * @return $this
     */
    public function add($value);

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return mixed
     */
    public function apply(Builder $query);
}
