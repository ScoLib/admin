<?php


namespace Sco\Admin\Contracts;


use Illuminate\Database\Eloquent\Model;

interface Repository
{
    /**
     * @return Model
     */
    public function getModel();

    public function setModel(Model $model);

    public function getClass();

    public function setClass($class);

    /**
     * @return bool
     */
    public function isRestorable();
}
