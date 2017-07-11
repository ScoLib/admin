<?php


namespace Sco\Admin\Config;

use AdminElement;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Application;
use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Sco\Admin\Contracts\ConfigManagerInterface;

class ConfigManager implements ConfigManagerInterface, Arrayable, Jsonable, JsonSerializable
{
    protected $app;

    protected $name;
    protected $configRepository;

    protected $title;
    protected $permissions;
    protected $columns;
    protected $model;
    protected $elements;

    public function __construct($name, Application $app, Repository $repository)
    {
        $this->name             = $name;
        $this->app              = $app;
        $this->configRepository = $repository;
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

    /**
     * Convert the Object instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getConfigs();
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Convert the Object instance to JSON.
     *
     * @param  int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    public function __toString()
    {
        return $this->toJson();
    }
}
