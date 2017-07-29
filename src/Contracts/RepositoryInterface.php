<?php


namespace Sco\Admin\Contracts;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
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

    /**
     * @return string[]
     */
    public function getWith();

    public function with($relations);

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getQuery();

    /**
     * @param $id
     *
     * @return Model
     */
    public function findOnlyTrashed($id);
}
