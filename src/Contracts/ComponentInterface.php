<?php

namespace Sco\Admin\Contracts;

interface ComponentInterface
{
    /**
     * Configure Model class
     *
     * @return string
     */
    public function model();

    /**
     * Get name of the component
     *
     * @return string
     */
    public function getName();

    /**
     * Get display name of the component
     *
     * @return string
     */
    public function getTitle();

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel();

    /**
     * @return mixed|\Sco\Admin\Contracts\RepositoryInterface
     */
    public function getRepository();

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getConfigs();

    /**
     * @return \Sco\Admin\Contracts\View\ViewInterface
     */
    public function fireView();

    public function get();

    /**
     * @return \Sco\Admin\Contracts\Form\FormInterface
     */
    public function fireCreate();

    /**
     * @return mixed
     */
    public function store();

    /**
     * @param $id
     *
     * @return \Sco\Admin\Contracts\Form\FormInterface
     */
    public function fireEdit($id);

    /**
     * @param mixed $id
     *
     * @return mixed
     */
    public function update($id);

    public function delete($id);

    public function forceDelete($id);

    public function restore($id);


    public function isView();

    public function isCreate();

    public function isEdit();

    public function isDelete();

    public function isDestroy();

    public function isRestore();

    public function observe($class);

    public function registerAbility($ability, $callback);

    public function can($ability);

    public function getAccesses();
}
