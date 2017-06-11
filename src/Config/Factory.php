<?php


namespace Sco\Admin\Config;


class Factory
{
    protected $configs = [];

    public function __construct()
    {

    }

    public function makeFromUri($uri)
    {
        $name = str_replace(DIRECTORY_SEPARATOR, '.', $uri);
        return $this->make($name);
    }

    public function make($name)
    {
        if (isset($this->configs[$name])) {
            return $this->configs[$name];
        }
        $options = $this->getConfigOptions($name);
        
        return $this->configs[$name] = $options ? new Config($options) : null;
    }

    protected function getConfigOptions($name)
    {
        if (file_exists($this->getConfigFilePath($name))) {
            return config(config('admin.model_config_dir') . '.' . $name);
        }
        throw new \InvalidArgumentException("not found model({$name}) config file");
    }

    protected function getConfigFilePath($name)
    {
        $modelPath = config_path(config('admin.model_config_dir'));
        if (!is_dir($modelPath)) {
            throw new \InvalidArgumentException('not found admin model config dir');
        }
        $file = str_replace('.', DIRECTORY_SEPARATOR, $name) . '.php';
        return $modelPath . DIRECTORY_SEPARATOR . $file;
    }
}