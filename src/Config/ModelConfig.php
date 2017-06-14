<?php

namespace Sco\Admin\Config;

use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Sco\Admin\Exceptions\InvalidArgumentException;

class ModelConfig extends Config implements ConfigInterface, Arrayable, Jsonable, JsonSerializable
{

    protected $orderBy = [];
    protected $modelFilters = [];

    /**
     * Get Model
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Sco\Admin\Exceptions\InvalidArgumentException
     */
    protected function getModel()
    {
        $modelName = $this->getOriginal('model');
        if (class_exists($modelName)) {
            return new $modelName();
        }
        throw new InvalidArgumentException("class {$modelName} not found");
    }

    public function filters($filters)
    {
        $this->modelFilters = $filters;
        return $this;
    }

    public function orderBy($column, $direction = 'asc')
    {
        $this->orderBy = compact('column', 'direction');
        return $this;
    }

    public function paginate()
    {
        $data = $this->parseWhere()
            ->orderBy($this->orderBy['column'], $this->orderBy['direction'])
            ->paginate(20);
    }

    protected function parseWhere()
    {
        $model = $this->getModel();
        if (!empty($this->modelFilters)) {
            foreach ($this->modelFilters as $key => $filter) {
                list($operator, $value) = is_array($filter) ? $filter : ['=', $filter];
                $model->where($key, $operator, $value);
            }
        }
        return $model;
    }
}
