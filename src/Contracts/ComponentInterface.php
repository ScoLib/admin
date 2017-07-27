<?php


namespace Sco\Admin\Contracts;

interface ComponentInterface
{
    public function boot();

    public function getName();

    public function getTitle();

    public function getModel();

    public function getRepository();

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getConfigs();

    public function get();

    public function isView();

    public function isCreate();

    public function isEdit();

    public function isDelete();

    public function isDestroy();

    public function isRestore();

    public function registerObserver($class = null);

    public function registerPermission($permission, $callback);

    public function can($permission);

    public function getPermissions();
}