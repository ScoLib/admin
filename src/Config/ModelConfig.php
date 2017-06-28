<?php

namespace Sco\Admin\Config;

use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Foundation\Application;
use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Sco\Admin\Contracts\Config as ConfigContract;
use Sco\Admin\Contracts\Repository as RepositoryContract;
use Sco\Attributes\HasAttributesTrait;

class ModelConfig implements Arrayable, Jsonable, JsonSerializable
{
    use HasAttributesTrait;

    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * @var \Sco\Admin\Contracts\Config
     */
    protected $configFactory;
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    //protected $model;

    /**
     * @var mixed|\Sco\Admin\Repositories\Repository
     */
    protected $repository;

    protected $config;

    public function __construct(Application $app, ConfigContract $factory)
    {
        $this->app = $app;
        $this->configFactory = $factory;
        //$this->model = $model;
        $this->config = new ConfigRepository(
            $this->getConfigValues()
        );

        $this->repository = $this->app->make(RepositoryContract::class);

        $this->repository->setClass(
            $this->config->get('class')
        );
    }

    /**
     * @return mixed|\Sco\Admin\Repositories\Repository
     */
    public function getRepository()
    {
        return $this->repository;
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
        $orderBy = $this->config->get('orderBy', [$this->getRepository()->getKeyName(), 'desc']);
        $query = $this->getRepository()->orderBy($orderBy[0], $orderBy[1]);

        if ($this->usePagination()) {
            $data = $query->paginate($this->config->get('perPage'));

            $data->setCollection($this->parseRows($data->items()));
        } else {
            $data = $this->parseRows($query->get());
        }


        return $data;
    }

    public function delete($id)
    {

    }

    protected function usePagination()
    {
        return $this->config->get('perPage') > 0;
    }

    protected function getConfigValues()
    {
        $config = $this->configFactory->getConfigRepository()->get('model');
        if (is_string($config)) {
            $config = [
                'class' => $config
            ];
        }
        $config = array_merge([
            //'orderBy' => [],
            'perPage' => 10,
        ], $config);
        return $config;
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    /*public function __call($method, $parameters)
    {
        if (in_array($method, ['getKeyName'])) {
            return $this->model->$method(...$parameters);
        }

        $this->model = $this->model->$method(...$parameters);
        return $this;
    }*/

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    /*public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }*/
}
