<?php

namespace Sco\Admin\Config;

use AdminElement;
use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Foundation\Application;
use Sco\Admin\Column\Columns;
use Sco\Admin\Contracts\ConfigFactoryInterface;
use Sco\Attributes\HasAttributesTrait;

class ConfigFactory implements ConfigFactoryInterface, Arrayable, Jsonable, JsonSerializable
{
    use HasAttributesTrait;

    protected $app;
    protected $name;
    protected $configRepository;

    protected $title;
    protected $permissions;
    protected $columns;
    protected $model;
    protected $elements;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * {@inheritdoc}
     */
    public function make($name)
    {
        $this->name = $name;

        $this->configRepository = new ConfigRepository(
            $this->app['files']->getRequire($this->getConfigFile())
        );

        return $this;
    }

    private function getConfigFile()
    {
        return $this->app['path.config']
            . DIRECTORY_SEPARATOR . 'admin'
            . DIRECTORY_SEPARATOR . $this->name . '.php';
    }

    public function getConfigRepository()
    {
        return $this->configRepository;
    }

    public function getTitle()
    {
        if (!$this->title) {
            $this->title = $this->configRepository->get('title');
        }

        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function getPermissions()
    {
        if (!$this->permissions) {
            $config = $this->configRepository->get('permissions');

            $this->permissions = new PermissionsConfig($config);
        }

        return $this->permissions;
    }

    public function getColumns()
    {
        if (!$this->columns) {
            $config = $this->configRepository->get('columns');

            $this->columns = collect($config)->mapWithKeys(function ($item, $key) {
                $columnClass = config('admin.column');
                return [$key => new $columnClass($key, $item)];
            });
        }

        return $this->columns;
    }

    protected function getElements()
    {
        if (!$this->elements) {
            $config         = $this->configRepository->get('elements');
            $this->elements = collect($config)->mapWithKeys(function ($item, $key) {
                $type = isset($item['type']) ? $item['type'] : 'text';
                return [$key => AdminElement::{$type}($key, $item['title'])];
            });
        }

        return $this->elements;
    }

    /**
     * {@inheritdoc}
     */
    public function getModel()
    {
        if (!$this->model) {
            $this->model = new ModelFactory($this->app, $this);
        }
        return $this->model;
    }

    public function getRules()
    {
        return $this->configRepository->get('rules');
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigs()
    {
        return [
            'primaryKey'  => $this->getModel()->getRepository()->getKeyName(),
            'title'       => $this->getTitle(),
            'permissions' => $this->getPermissions(),
            'columns'     => $this->getColumns()->values(),
            'elements'    => $this->getElements()->values(),
        ];
    }

    public function __toString()
    {
        return $this->toJson();
    }
}
