<?php


namespace Sco\Admin\Contracts;

interface ConfigFactoryInterface
{
    /**
     * @param string $name
     *
     * @return \Sco\Admin\Contracts\ConfigManagerInterface
     */
    public function make($name);

    /**
     * @return \Illuminate\Config\Repository
     */
    public function getConfigRepository();
}
