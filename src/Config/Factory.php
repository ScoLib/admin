<?php

namespace Sco\Admin\Config;

use Sco\Admin\Exceptions\InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Factory
{
    protected $configs = [];

    public function __construct()
    {

    }

    public function makeFromUri($uri)
    {
        $name = $this->getNestedConfigName($uri);
        return $this->make($name);
    }

    protected function getNestedConfigName($uri)
    {
        return str_replace('/', '.', $uri);
    }

    public function make($name)
    {
        if (isset($this->configs[$name])) {
            return $this->configs[$name];
        }
        $options = $this->getConfigOptions($name);

        return $this->configs[$name] = $options ? new ModelConfig($options) : null;
    }

    protected function getConfigOptions($name)
    {
        if (file_exists($this->getConfigFilePath($name))) {
            return config(config('admin.model_config_dir') . '.' . $name);
        }
        throw new NotFoundHttpException("not found model({$name}) config file");
    }

    protected function getConfigFilePath($name)
    {
        $modelPath = config_path(config('admin.model_config_dir'));
        if (!is_dir($modelPath)) {
            throw new InvalidArgumentException('admin config(model_config_dir) is not a directory');
        }
        $file = str_replace('.', DIRECTORY_SEPARATOR, $name) . '.php';
        return $modelPath . DIRECTORY_SEPARATOR . $file;
    }
}
