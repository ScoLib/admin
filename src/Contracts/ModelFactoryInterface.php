<?php


namespace Sco\Admin\Contracts;

interface ModelFactoryInterface
{
    /**
     * @return \Sco\Admin\Contracts\RepositoryInterface
     */
    public function getRepository();

    /**
     * @return \Sco\Admin\Contracts\ConfigManagerInterface
     */
    public function getConfigManager();

    /**
     * @return mixed
     */
    public function get();

    public function store();

    public function update();

    public function delete($id);

    public function restore($id);

    public function forceDelete($id);
}
