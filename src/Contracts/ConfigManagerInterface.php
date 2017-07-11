<?php


namespace Sco\Admin\Contracts;

interface ConfigManagerInterface
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

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getColumns();

    /**
     * @return \Illuminate\Config\Repository
     */
    public function getConfigRepository();

    /**
     * @return \Sco\Admin\Config\ModelFactory
     */
    public function getModel();
}
