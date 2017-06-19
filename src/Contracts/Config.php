<?php


namespace Sco\Admin\Contracts;

interface Config
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function getConfigs();
    public function getTitle();

    /**
     * @return \Sco\Admin\Config\PermissionsConfig
     */
    public function getPermissions();
    public function getColumns();

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel();
}
