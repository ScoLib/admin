<?php

namespace Sco\Admin\Contracts\View;

use Illuminate\Database\Eloquent\Model;

interface ColumnInterface
{
    public function getName();

    public function setWidth($width);

    public function setMinWidth($width);

    public function isSortable();

    public function isCustomSortable();

    public function isFixed();

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel();

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return $this
     */
    public function setModel(Model $model);

    public function getModelValue();
}
