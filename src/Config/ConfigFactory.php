<?php

namespace Sco\Admin\Config;

use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Foundation\Application;
use Sco\Admin\Column\Columns;
use Sco\Admin\Contracts\Config as ConfigContract;
use Sco\Attributes\HasOriginalAndAttributesTrait;

class ConfigFactory implements ConfigContract, Arrayable, Jsonable, JsonSerializable
{
    use HasOriginalAndAttributesTrait;

    protected $app;
    protected $name;
    protected $config;

    protected $title;
    protected $permissions;
    protected $columns;
    protected $model;

    public function __construct(Application $app, $name)
    {
        $this->app  = $app;
        $this->name = $name;

        $this->config = new ConfigRepository(
            $this->app['files']->getRequire($this->getConfigFile())
        );
    }

    private function getConfigFile()
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
        if (!$this->columns) {
            $config = $this->config->get('columns');

            $this->columns = new Columns($config);
        }

        return $this->columns;
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

    /**
     * @return \Sco\Admin\Config\ModelConfig
     */
    public function getModel()
    {
        if (!$this->model) {
            $class       = $this->config->get('model');
            $this->model = new ModelConfig($this, new $class());
        }
        return $this->model;
    }

    public function getConfigs()
    {
        $this->setAttribute([
            'primaryKey' => $this->getModel()->getKeyName(),
            'title'       => $this->getTitle(),
            'permissions' => $this->getPermissions(),
            'columns'     => $this->getColumns(),
        ]);

        return $this->getAttributes();
    }


    public function __toString()
    {
        return $this->toJson();
    }
}
