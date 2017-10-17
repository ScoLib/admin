<?php

namespace Sco\Admin\Contracts\View;

use Sco\Admin\Contracts\RepositoryInterface;

interface ViewInterface
{
    /**
     * @param \Sco\Admin\Contracts\RepositoryInterface $repository
     *
     * @return $this
     */
    public function setRepository(RepositoryInterface $repository);

    /**
     * @return \Sco\Admin\Contracts\RepositoryInterface
     */
    public function getRepository();

    /**
     * @return string[]
     */
    public function getWith();

    /**
     * @param array|string[] ...$relations
     *
     * @return $this
     */
    public function with($relations);

    public function get();
}
