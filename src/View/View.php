<?php

namespace Sco\Admin\View;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Sco\Admin\Contracts\RepositoryInterface;
use Sco\Admin\Contracts\View\ViewInterface;

abstract class View implements ViewInterface, Arrayable
{
    /**
     * @var array
     */
    protected $with = [];

    /**
     * @var RepositoryInterface
     */
    protected $repository;

    protected $scopes;

    protected $applies;

    protected $filters;

    protected $type;

    protected $extensions;

    public function __construct()
    {
        $this->scopes  = new Collection();
        $this->applies = new Collection();
        $this->filters = new Collection();
    }

    public function initialize()
    {
        //$this->extensions->initialize();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getFilters(): Collection
    {
        return $this->filters;
    }

    /**
     * @param mixed $filters
     *
     * @return $this
     */
    public function setFilters($filters)
    {
        $filters = is_array($filters) ? $filters : (array)$filters;
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }

        return $this;
    }

    public function addFilter($filter)
    {
        $this->filters->push($filter);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getScopes(): Collection
    {
        return $this->scopes;
    }

    /**
     * @param mixed $scopes
     *
     * @return $this
     */
    public function setScopes($scopes)
    {
        $scopes = is_array($scopes) ? $scopes : (array)$scopes;
        foreach ($scopes as $scope) {
            $this->addScope($scope);
        }

        return $this;
    }


    public function addScope($scope)
    {
        $this->scopes->push($scope);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getApplies()
    {
        return $this->applies;
    }

    /**
     * @param mixed $applies
     *
     * @return $this
     */
    public function setApplies($applies)
    {
        $applies = is_array($applies) ? $applies : (array)$applies;
        foreach ($applies as $apply) {
            $this->addApply($apply);
        }

        return $this;
    }

    public function addApply($apply)
    {
        $this->applies->push($apply);

        return $this;
    }

    public function setRepository(RepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->repository->with($this->getWith());

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

        $builder = $repository->getQuery();

        if ($repository->isRestorable()) {
            $builder->withTrashed();
        }

        return $builder;
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
        $this->scopes['orderBy'] = function (Builder $builder) use ($column, $direction) {
            $builder->orderBy($column, $direction);
        };

        return $this;
    }

    public function toArray()
    {
        return [
            'type' => $this->type,
        ];
    }
}
