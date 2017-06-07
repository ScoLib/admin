<?php


namespace Sco\Admin\Config;


class Factory
{
    protected $config = null;

    public function __construct()
    {

    }

    public function makeFromUri($uri)
    {
        $name = str_replace('/', '.', $uri);
        return $this->make($name);
    }

    public function make($name)
    {
        $config = null;
        $options = $this->getConfigOptions($name);
        if ($options) {
            $config = new Config($options);
        }
        $this->config = $config;

        return $config;
    }

    protected function getConfigOptions($name)
    {
        $name = config('admin.model_config_dir') . '.' . $name;
        return config($name);
    }
}