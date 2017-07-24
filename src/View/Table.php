<?php


namespace Sco\Admin\View;

use Illuminate\Support\Collection;
use Sco\Admin\Contracts\ColumnInterface;

class Table extends View
{
    protected $perPage = 20;

    protected $pageName = 'page';

    protected $columns;

    public function __construct()
    {
        $this->columns = new Collection();
    }

    /**
     * @param array $columns
     *
     * @return $this
     */
    public function setColumns(array $columns)
    {
        foreach ($columns as $column) {
            $this->columns->push($column);
        }

        return $this;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * {@inheritdoc}
     */
    public function paginate($perPage = 25, $pageName = 'page')
    {
        $this->perPage = (int) $perPage;
        $this->pageName = $pageName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function disablePagination()
    {
        $this->perPage = 0;

        return $this;
    }

    /**
     * @return bool
     */
    public function usePagination()
    {
        return $this->perPage > 0;
    }

    public function get()
    {
        $repository = $this->getRepository();
        //$orderBy = $this->config->get('orderBy', [$repository->getKeyName(), 'desc']);
        $query = $repository->getQuery();

        if ($repository->isRestorable()) {
            $query->withTrashed();
        }

        if ($this->usePagination()) {
            $data = $query->paginate($this->perPage, ['*'], $this->pageName);

            $data->setCollection($this->parseRows($data->getCollection()));
        } else {
            $data = $this->parseRows($query->get());
        }

        return $data;
    }

    public function toArray()
    {
        return parent::toArray() + [
            'columns' => $this->getColumns(),
        ];
    }

    protected function parseRows(Collection $rows)
    {
        if ($rows) {
            return $rows->map(function ($row) {
                    $newRow = $this->getColumns()->mapWithKeys(function (ColumnInterface $column) use ($row) {
                        return [$column->getName() => $column->setModel($row)->getModelValue()];
                    });

                // whether this row has been soft deleted
                if ($this->getRepository()->isRestorable()) {
                    $newRow->put('_deleted', $row->trashed() ? 1 : 0);
                }
                return $newRow;
            });
        }
        return collect();
    }
}
