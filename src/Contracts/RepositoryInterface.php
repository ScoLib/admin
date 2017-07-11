<?php


namespace Sco\Admin\Contracts;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * @return Model
     */
    public function getModel();

    public function setModel(Model $model);

    public function getClass();

    public function setClass($class);


    public function store();

    public function update();

    public function forceDelete($id);

    public function restore($id);

    /**
     * @return bool
     */
    public function isRestorable();
}
