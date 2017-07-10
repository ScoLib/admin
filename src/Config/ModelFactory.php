<?php

namespace Sco\Admin\Config;

use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Foundation\Application;
use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Sco\Admin\Contracts\ConfigFactoryInterface;
use Sco\Admin\Contracts\ModelFactoryInterface;
use Sco\Admin\Contracts\RepositoryInterface;

class ModelFactory implements ModelFactoryInterface
{
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

    public function __construct(Application $app, ConfigFactoryInterface $factory)
    {
        $this->app = $app;
        $this->configFactory = $factory;
        $this->config = new ConfigRepository(
            $this->getConfigValues()
        );

        $this->repository = $this->app->make(RepositoryInterface::class);

        $this->repository->setClass(
            $this->config->get('class')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @return \Sco\Admin\Contracts\ConfigFactoryInterface
     */
    public function getConfigFactory()
    {
        return $this->configFactory;
    }

    public function get()
    {
        $repository = $this->getRepository();
        $orderBy = $this->config->get('orderBy', [$repository->getKeyName(), 'desc']);
        $query = $repository->orderBy($orderBy[0], $orderBy[1]);

        if ($repository->isRestorable()) {
            $query = $query->withTrashed();
        }

        if ($this->usePagination()) {
            $data = $query->paginate($this->config->get('perPage'));

            $data->setCollection($this->parseRows($data->items()));
        } else {
            $data = $this->parseRows($query->get());
        }

        return $data;
    }

    public function store()
    {
        $this->validate();
    }

    public function update()
    {
    }

    public function delete($id)
    {
        $this->getRepository()->findOrFail($id)->delete();
        return true;
    }

    public function forceDelete($id)
    {
        $this->getRepository()->forceDelete($id);
        return true;
    }

    public function restore($id)
    {
        $this->getRepository()->restore($id);
    }

    protected function parseRows($rows)
    {
        $data = collect();
        if ($rows) {
            foreach ($rows as $row) {
                $newRow = collect();
                foreach ($this->configFactory->getColumns() as $column) {
                    $newRow->put($column->getName(), $column->setModel($row)->render());

                    // whether this row has been soft deleted
                    if ($this->getRepository()->isRestorable()) {
                        $newRow->put('_deleted', $row->trashed() ? 1 : 0);
                    }
                }
                $data->push($newRow);
            }
        }
        return $data;
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

    protected function validate()
    {
        $this->app->make(Factory::class)->validate($data, $rules, $messages, $customAttributes);
    }
}
