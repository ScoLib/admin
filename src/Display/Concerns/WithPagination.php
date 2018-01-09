<?php

namespace Sco\Admin\Display\Concerns;

trait WithPagination
{
    protected $perPage = 20;

    protected $pageName = 'page';

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @param int $perPage
     * @return $this
     */
    public function setPerPage(int $perPage)
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * @return string
     */
    public function getPageName(): string
    {
        return $this->pageName;
    }

    /**
     * @param string $pageName
     * @return $this
     */
    public function setPageName(string $pageName)
    {
        $this->pageName = $pageName;

        return $this;
    }

    public function paginate()
    {
        return $this->getQuery()
            ->paginate($this->getPerPage(), ['*'], $this->getPageName())
            ->appends(request()->except($this->getPageName()));
    }

    /**
     * @return $this
     */
    public function disablePagination()
    {
        return $this->setPerPage(0);
    }

    /**
     * @return bool
     */
    public function isPagination()
    {
        return $this->getPerPage() > 0;
    }
}
