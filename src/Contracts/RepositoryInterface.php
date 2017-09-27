<?php

namespace Sco\Admin\Contracts;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function getClass();

    public function setClass($class);

    /**
     * @param $id
     *
     * @return Model
     */
    public function find($id);

    /**
     * @param $id
     *
     * @return Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail($id);

    //public function store();

    //public function update();

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

    public function addGlobalScope($scopes);

    public function getGlobalScopes();

    /**
     * @param $id
     *
     * @return Model
     */
    public function findOnlyTrashed($id);
}
