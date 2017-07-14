<?php


namespace Sco\Admin\Contracts;


interface ComponentInterface
{

    public function boot();

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getConfigs();
}
