<?php


namespace Sco\Admin\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Application;
use InvalidArgumentException;
use Sco\Admin\Contracts\RepositoryInterface;
use Sco\Admin\Contracts\WithModel;

class Repository implements RepositoryInterface, WithModel
{
    protected $app;

    protected $model;

    /**
     * @var Model
     */
    protected $class;

    protected $with = [];

    protected $globalScopes = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel(Model $model)
    {
        $this->model = $model;
        $this->class = get_class($model);

        return $this;
    }

    /**
     * @return string[]
     */
    public function getWith()
    {
        return $this->with;
    }

    public function with($relations)
    {
        $this->with = array_flatten(func_get_args());

        return $this;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function setClass($class)
    {
        if (!class_exists($class)) {
            throw new InvalidArgumentException("Model class {$class} not found.");
        }

        $this->class = $class;
        $this->setModel(
            new $class()
        );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        $model = $this->getModel();
        foreach ($this->getGlobalScopes() as $identifier => $scope) {
            $model::addGlobalScope($identifier, $scope);
        }

        return $model->query()->with($this->getWith());
    }

    public function addGlobalScope($scopes)
    {
        $this->globalScopes = $scopes;
    }

    public function getGlobalScopes()
    {
        return $this->globalScopes;
    }

    public function find($id)
    {
        $query = $this->getQuery();
        if ($this->isRestorable()) {
            $query->withTrashed();
        }

        return $query->find($id);
    }

    public function findOrFail($id)
    {
        $query = $this->getQuery();
        if ($this->isRestorable()) {
            $query->withTrashed();
        }

        return $query->findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findOnlyTrashed($id)
    {
        return $this->getQuery()->onlyTrashed()->findOrFail($id);
    }

    /*public function store()
    {
    }

    public function update()
    {
    }*/


    public function forceDelete($id)
    {
        return $this->findOnlyTrashed($id)->forceDelete();
    }

    public function restore($id)
    {
        return $this->findOnlyTrashed($id)->restore();
    }


    public function isRestorable()
    {
        return in_array(SoftDeletes::class, class_uses_recursive($this->getClass()));
    }
}
