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
}
