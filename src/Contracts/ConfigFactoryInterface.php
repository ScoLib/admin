<?php


namespace Sco\Admin\Contracts;

interface ConfigFactoryInterface
{
    /**
     * @param string $name
     *
     * @return $this;
     */
    public function make($name);

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
     * @return \Illuminate\Config\Repository
     */
    public function getConfigRepository();

    /**
     * @return \Sco\Admin\Config\ModelConfig
     */
    public function getModel();
}
