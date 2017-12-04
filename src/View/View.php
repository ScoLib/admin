<?php

namespace Sco\Admin\View;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Sco\Admin\Contracts\RepositoryInterface;
use Sco\Admin\Contracts\View\Extensions\ExtensionInterface;
use Sco\Admin\Contracts\View\ViewInterface;
use Sco\Admin\View\Extensions\Applies;
use Sco\Admin\View\Extensions\Filters;
use Sco\Admin\View\Extensions\Scopes;

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

    protected $type;

    protected $extensions;

    public function __construct()
    {
        $this->extensions = new Extensions();

        $this->extend('scopes', new Scopes());
        $this->extend('applies', new Applies());
        $this->extend('filters', new Filters());
    }

    public function initialize()
    {
        $this->extensions->initialize();
    }

    public function extend($name, ExtensionInterface $extension)
    {
        $this->extensions->put($name, $extension);
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

    public function __call($name, $parameters)
    {
        dump($name, $parameters);
        $method = substr($name, 3);

        dump($method, str_plural($method));
        if (starts_with($name, 'get') && $this->extensions->has(str_plural($method))) {
            return $this->extensions->get($method);
        }

        if (starts_with($name, 'set') && $this->extensions->has($method)) {
            $extension = $this->extensions->get($method);

        }


    }
}
