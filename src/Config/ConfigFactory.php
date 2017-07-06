<?php

namespace Sco\Admin\Config;

use AdminField;
use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Foundation\Application;
use Sco\Admin\Column\Columns;
use Sco\Admin\Contracts\Config as ConfigContract;
use Sco\Attributes\HasAttributesTrait;

class ConfigFactory implements ConfigContract, Arrayable, Jsonable, JsonSerializable
{
    use HasAttributesTrait;

    protected $app;
    protected $name;
    protected $config;

    protected $title;
    protected $permissions;
    protected $columns;
    protected $model;
    protected $fields;

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

    public function getConfigRepository()
    {
        return $this->config;
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

            $this->columns = collect($config)->mapWithKeys(function ($item, $key) {
                $columnClass = config('admin.column');
                return [$key => new $columnClass($key, $item)];
            });
        }

        return $this->columns;
    }

    protected function getFields()
    {
        if (!$this->fields) {
            $config = $this->config->get('fields');
            $this->fields = collect($config)->mapWithKeys(function ($item, $key) {
                return [$key => AdminField::text($key, $item['title'])];
            });
        }

        return $this->fields;
    }

    /**
     * @return \Sco\Admin\Config\ModelConfig
     */
    public function getModel()
    {
        if (!$this->model) {
            $this->model = new ModelConfig($this->app, $this);
        }
        return $this->model;
    }

    public function getConfigs()
    {
        return [
            'primaryKey'  => $this->getModel()->getRepository()->getKeyName(),
            'title'       => $this->getTitle(),
            'permissions' => $this->getPermissions(),
            'columns'     => $this->getColumns()->values(),
            'fields'      => $this->getFields()->values(),
        ];
    }

    public function __toString()
    {
        return $this->toJson();
    }
}
