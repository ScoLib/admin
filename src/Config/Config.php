<?php

namespace Sco\Admin\Config;

use Illuminate\Foundation\Application;
use Sco\Attributes\HasOriginalAndAttributesTrait;

abstract class Config
{
    use HasOriginalAndAttributesTrait;

    protected $app;
    protected $name;
    protected $config;

    protected $defaultPermissions = [
        'view'   => true,
        'create' => true,
        'update' => true,
        'delete' => true,
    ];

    public function __construct(Application $app, $name)
    {
        $this->app = $app;
        $this->name = $name;

        $this->config = $this->compileConfig();
        //$this->setOriginal($attributes);
        $this->getOptions();
    }

    protected function compileConfig()
    {
    }

    protected function getTitle()
    {
        $title = $this->getAttribute('title');
        if ($title) {
            return $title;
        }

        $title = $this->getOriginal('title');
        $this->setAttribute('title', $title);
        return $title;
    }

    protected function getPermissions()
    {
        $permissions = $this->getAttribute('permissions', collect());
        if ($permissions->isEmpty()) {
            $option = $this->getOriginal('permissions');
            if (is_array($option)) {
                $option = array_merge($this->defaultPermissions, $option);
                foreach ($option as $key => $item) {
                    $val = $item instanceof \Closure ? $item() : $item;
                    $permissions->put($key, $val ? true : false);
                }
            } else {
                $val = $option instanceof \Closure ? $option() : $option;
                foreach ($this->defaultPermissions as $key => $item) {
                    $permissions->put($key, $val ? true : false);
                }
            }
            $this->setAttribute('permissions', $permissions);
        }

        return $permissions;
    }

    protected function getColumns()
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

    public function getOptions()
    {
        $this->getTitle();
        $this->getPermissions();
        //$this->getColumns();

        return $this->getAttributes();
    }

    public function __toString()
    {
        return $this->toJson();
    }
}
