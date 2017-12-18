<?php

namespace Sco\Admin\View;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Sco\Admin\Contracts\RepositoryInterface;
use Sco\Admin\Contracts\View\Extensions\ExtensionInterface;
use Sco\Admin\Contracts\View\ViewInterface;
use Sco\Admin\View\Extensions\Applies;
use Sco\Admin\View\Extensions\Filters;
use Sco\Admin\View\Extensions\Scopes;
use Sco\Admin\Contracts\View\Filters\FilterInterface;

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
abstract class View implements ViewInterface, Arrayable
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

    public function extend($name, ExtensionInterface $extension)
    {
        $this->extensions->put($name, $extension);
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

    /**
     * Add an "order by" clause to the query.
     *
     * @param  string $column
     * @param  string $direction
     *
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->addApply(function (Builder $query) use ($column, $direction) {
            $query->orderBy($column, $direction);
        });

        return $this;
    }

    public function toArray()
    {
        return [
            'type'    => $this->type,
            'filters' => [
                'elements' => $this->getFilters(),
                'values'   => $this->getFilters()->getViewValues(),
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
