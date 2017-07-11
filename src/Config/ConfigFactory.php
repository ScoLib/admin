<?php

namespace Sco\Admin\Config;

use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Sco\Admin\Contracts\ConfigFactoryInterface;

class ConfigFactory implements ConfigFactoryInterface
{
    protected $app;
    protected $configManagers;
    protected $configRepository;


    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->configManagers = new Collection();
    }

    /**
     * {@inheritdoc}
     */
    public function make($name)
    {
        if ($this->configManagers->get($name)) {
            return $this->configManagers->get($name);
        }

        $this->configRepository = new ConfigRepository(
            $this->app['files']->getRequire($this->getConfigFile($name))
        );

        $this->configManagers->put(
            $name,
            new ConfigManager($name, $this->app, $this->configRepository)
        );
        return $this->configManagers->get($name);
    }

    private function getConfigFile($name)
    {
        return $this->app['path.config']
            . DIRECTORY_SEPARATOR . 'admin'
            . DIRECTORY_SEPARATOR . $name . '.php';
    }

    public function getConfigRepository()
    {
        return $this->configRepository;
    }
}
