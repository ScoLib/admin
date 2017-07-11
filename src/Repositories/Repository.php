<?php


namespace Sco\Admin\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sco\Admin\Contracts\RepositoryInterface;
use Sco\Admin\Exceptions\RepositoryException;

/**
 * @method static \Illuminate\Database\Eloquent\Model getKeyName()
 */
class Repository implements RepositoryInterface
{
    protected $model;

    protected $class;

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

    public function getClass()
    {
        return $this->class;
    }

    public function setClass($class)
    {
        if (!class_exists($class)) {
            throw new RepositoryException("Class {$class} not found.");
        }

        $this->class = $class;
        $this->setModel(
            new $class()
        );

        return $this;
    }

    /**
     * @param $id
     *
     * @return Model
     */
    public function findOnlyTrashed($id)
    {
        return $this->getModel()->onlyTrashed()->findOrFail($id);
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

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string $method
     * @param  array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->getModel()->$method(...$parameters);
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string $method
     * @param  array  $parameters
     *
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }
}
