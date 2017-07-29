<?php

namespace Sco\Admin\Contracts;

use Illuminate\Database\Eloquent\Model;

interface WithModel
{
    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return $this
     */
    public function setModel(Model $model);

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel();
}
