<?php

namespace Sco\Admin\Config;

use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Sco\Admin\Exceptions\InvalidArgumentException;
use Sco\Admin\Contracts\Config as ConfigContract;

class ModelConfig extends Config implements ConfigContract, Arrayable, Jsonable, JsonSerializable
{

    protected $orderBy = [];
    protected $wheres = [];

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

    public function where($filters)
    {
        $this->wheres = $filters;
        return $this;
    }

    public function orderBy($column, $direction = 'asc')
    {
        $this->orderBy = compact('column', 'direction');
        return $this;
    }

    public function paginate($perPage = null)
    {
        $model = $this->compileWhere();
        if (!empty($this->orderBy)) {
            $model->orderBy($this->orderBy['column'], $this->orderBy['direction']);
        }

        $data = $model->paginate($perPage);
        return $data;
    }

    protected function compileWhere()
    {
        $model = $this->getModel();
        if (!empty($this->wheres)) {
            foreach ($this->wheres as $key => $where) {
                list($operator, $value) = is_array($where) ? $where : ['=', $where];
                $model->where($key, $operator, $value);
            }
        }
        return $model;
    }
}
