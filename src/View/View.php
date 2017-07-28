<?php

namespace Sco\Admin\View;

use Illuminate\Contracts\Support\Arrayable;
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

    public function toArray()
    {
        return [];
    }
}
