<?php

namespace Sco\Admin\View;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
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

    protected $scopes = [];

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
        $repository->addGlobalScope($this->scopes);

        $builder = $repository->getQuery();

        if ($repository->isRestorable()) {
            $builder->withTrashed();
        }

        return $builder;
    }

    /**
     * Add an "order by" clause to the query.
     *
     * @param  string  $column
     * @param  string  $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->scopes['orderBy'] = function (Builder $builder) use ($column, $direction) {
            $builder->orderBy($column, $direction);
        };
    }

    public function toArray()
    {
        return [];
    }
}
