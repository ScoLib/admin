<?php

namespace Sco\Admin\Config;

use Illuminate\Database\Eloquent\Model;
use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Sco\Admin\Contracts\Config as ConfigContract;
use Sco\Attributes\HasAttributesTrait;

class ModelConfig implements Arrayable, Jsonable, JsonSerializable
{
    use HasAttributesTrait;

    protected $configFactory;
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function __construct(ConfigContract $factory, Model $model)
    {
        $this->configFactory = $factory;
        $this->model = $model;
    }

    public function paginate($perPage = null)
    {
        $data = $this->model->paginate($perPage);
        return $data;
    }

    public function get()
    {
        $data = $this->model->get();
        return $data;
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (in_array($method, ['getKeyName'])) {
            return $this->model->$method(...$parameters);
        }

        $this->model->$method(...$parameters);
        return $this;
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }
}
