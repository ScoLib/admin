<?php

namespace Sco\Admin\Display;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Sco\Admin\Contracts\RepositoryInterface;
use Sco\Admin\Contracts\Display\Extensions\ExtensionInterface;
use Sco\Admin\Contracts\Display\DisplayInterface;
use Sco\Admin\Display\Extensions\Applies;
use Sco\Admin\Display\Extensions\Filters;
use Sco\Admin\Display\Extensions\Scopes;
use Sco\Admin\Contracts\Display\Filters\FilterInterface;

/**
 * @method Scopes getScopes() get query scopes
 * @method $this setScopes($scope, ...$scopes) set query scopes
 * @method $this addScope($scope, $parameter, ...$parameters) add query scope
 *
 * @method Applies getApplies() get query applies
 * @method $this setApplies(\Closure $apply, ...$applies) set query applies
 * @method $this addApply(\Closure $apply) add query apply
 *
 * @method Filters getFilters()
 * @method $this setFilters(FilterInterface $filter, ...$filters)
 * @method $this addFilter(FilterInterface $filter)
 *
 */
abstract class Display implements DisplayInterface, Arrayable
{
    /**
     * @var array
     */
    protected $with = [];

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * @var RepositoryInterface
     */
    protected $repository;

    protected $type;

    protected $extensions;

    abstract public function get();

    public function __construct()
    {
        $this->extensions = new Extensions();

        $this->extend('scopes', new Scopes());
        $this->extend('applies', new Applies());
        $this->extend('filters', new Filters());
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return $this
     */
    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return $this->model;
    }

    public function initialize()
    {
        $this->makeRepository();
        $this->extensions->initialize();
    }

    /**
     * {@inheritdoc}
     */
    public function extend($name, ExtensionInterface $extension)
    {
        $this->extensions->put($name, $extension);

        return $this;
    }

    protected function makeRepository()
    {
        $this->repository = app(RepositoryInterface::class)
            ->setModel($this->getModel())
            ->with($this->getWith());

        return $this;
    }

    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @return string[]
     */
    public function getWith()
    {
        return $this->with;
    }

    /**
     * {@inheritdoc}
     */
    public function with($relations)
    {
        $this->with = array_flatten(func_get_args());

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        $repository = $this->getRepository();

        $query = $repository->getQuery();

        if ($repository->isRestorable()) {
            $query->withTrashed();
        }

        $this->apply($query);

        return $query;
    }

    protected function apply(Builder $query)
    {
        $this->extensions->apply($query);
    }

    public function toArray()
    {
        return [
            'type'    => $this->type,
            'filters' => [
                'elements' => $this->getFilters(),
                'values'   => $this->getFilters()->getDisplayValues(),
            ],
        ];
    }

    public function __call($name, $parameters)
    {
        $method = snake_case(substr($name, 3));

        if (starts_with($name, 'get') && $this->extensions->has($method)) {
            return $this->extensions->get($method);
        }

        if (starts_with($name, 'set') && $this->extensions->has($method)) {
            $extension = $this->extensions->get($method);
            call_user_func_array([$extension, 'set'], $parameters);

            return $this;
        }

        if (starts_with($name, 'add') && $this->extensions->has(str_plural($method))) {
            $extension = $this->extensions->get(str_plural($method));
            call_user_func_array([$extension, 'add'], $parameters);

            return $this;
        }

        throw new \BadMethodCallException("Call to undefined method [{$name}]");
    }
}
