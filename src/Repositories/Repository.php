<?php


namespace Sco\Admin\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Application;
use Sco\Admin\Contracts\RepositoryInterface;
use Sco\Admin\Exceptions\RepositoryException;

/**
 * @method static \Illuminate\Database\Eloquent\Model getKeyName()
 */
class Repository implements RepositoryInterface
{
    protected $app;

    protected $model;

    protected $class;

    protected $with = [];

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
            throw new RepositoryException("Model class {$class} not found.");
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
        return $this->getModel()
            ->query()
            ->with($this->getWith());
    }

    /**
     * {@inheritdoc}
     */
    public function findOnlyTrashed($id)
    {
        return $this->getQuery()->onlyTrashed()->findOrFail($id);
    }

    public function store()
    {
    }

    public function update()
    {
    }


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
