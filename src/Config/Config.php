<?php

namespace Sco\Admin\Config;

use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Foundation\Application;
use Sco\Attributes\HasOriginalAndAttributesTrait;

abstract class Config
{
    use HasOriginalAndAttributesTrait;

    protected $app;
    protected $name;
    protected $config;

    protected $title;
    protected $permissions;
    protected $columns;

    public function __construct(Application $app, $name)
    {
        $this->app  = $app;
        $this->name = $name;

        $this->config = new ConfigRepository(
            $this->app['files']->getRequire($this->getConfigFile())
        );
    }

    public function getConfigFile()
    {
        return $this->app['path.config']
            . DIRECTORY_SEPARATOR . 'admin'
            . DIRECTORY_SEPARATOR . $this->name . '.php';
    }

    public function getTitle()
    {
        if (!$this->title) {
            $this->title = $this->config->get('title');
        }

        return $this->title;
    }

    /**
     * @return \Sco\Admin\Config\PermissionsConfig
     */
    public function getPermissions()
    {
        if (!$this->permissions) {
            $config = $this->config->get('permissions');

            $this->permissions = new PermissionsConfig($config);
        }

        return $this->permissions;
    }

    public function getColumns()
    {
        $columns = $this->getAttribute('columns', collect());
        if ($columns->isEmpty()) {
            $options = $this->getOriginal('columns');
            foreach ($options as $option) {
                $columns->push(app('admin.column')->make($option));
            }

            $this->setAttribute('columns', $columns);
        }

        return $columns;
    }

    protected function getFields()
    {
        $fields = $this->getAttribute('fields', collect());
        if ($fields->isEmpty()) {
            $options = $this->getOriginal('fields');

            foreach ($options as $option) {
                $fields->push($option);
            }
            $this->setAttribute('columns', $fields);
        }

        return $fields;
    }

    public function getConfigs()
    {
        $this->setAttribute([
            'title'       => $this->getTitle(),
            'permissions' => $this->getPermissions(),
            //'columns'     => $this->getColumns(),
        ]);

        return $this->getAttributes();
    }


    public function __toString()
    {
        return $this->toJson();
    }
}
