<?php

namespace Sco\Admin\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Sco\Admin\Contracts\Config as ConfigContract;
use Sco\Attributes\HasAttributesTrait;

/**
 * Class ModelConfig
 *
 * @method static \Illuminate\Database\Eloquent\Model|Model getKeyName()
 */
class ModelConfig implements Arrayable, Jsonable, JsonSerializable
{
    use HasAttributesTrait;

    protected $app;

    protected $configFactory;
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function __construct(Application $app, ConfigContract $factory, Model $model)
    {
        $this->app = $app;
        $this->configFactory = $factory;
        $this->model = $model;
    }

    public function paginate($perPage = null)
    {
        $data = $this->model->paginate($perPage);

        $data->setCollection($this->parseRows($data->items()));

        return $data;
    }

    protected function parseRows($rows)
    {
        $data = collect();
        if ($rows) {
            foreach ($rows as $row) {
                $newRow = collect();
                foreach ($this->configFactory->getColumns() as $column) {
                    $newRow->put($column->getName(), $column->setModel($row)->render());
                }
                $data->push($newRow);
            }
        }
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

        $this->model = $this->model->$method(...$parameters);
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
