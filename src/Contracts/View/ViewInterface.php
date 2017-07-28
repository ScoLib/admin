<?php

namespace Sco\Admin\Contracts\View;

use Sco\Admin\Contracts\RepositoryInterface;

interface ViewInterface
{
    /**
     * @param array $columns
     *
     * @return $this
     */
    public function setColumns(array $columns);

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getColumns();

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

    /**
     * @param int    $perPage
     * @param string $pageName
     *
     * @return $this
     */
    public function paginate($perPage, $pageName);

    /**
     * @return $this
     */
    public function disablePagination();

    /**
     * @return bool
     */
    public function usePagination();

    public function get();
}
