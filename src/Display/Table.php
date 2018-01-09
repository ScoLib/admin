<?php

namespace Sco\Admin\Display;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Sco\Admin\Contracts\Display\ColumnInterface;
use Sco\Admin\Display\Concerns\WithPagination;

class Table extends Display
{
    use WithPagination;

    protected $columns;

    protected $type = 'table';

    public function __construct()
    {
        parent::__construct();

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

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getColumns()
    {
        return $this->columns;
    }

    public function get()
    {
        if ($this->isPagination()) {
            $data = $this->paginate();

            return $data->setCollection($this->parseRows($data->getCollection()));
        }
        return $this->parseRows($this->getQuery()->get());
    }

    public function toArray()
    {
        return parent::toArray() + [
                'columns' => $this->getColumns(),
            ];
    }

    protected function parseRows(Collection $rows)
    {
        return $rows->map(function (Model $row) {
            $newRow = $this->getColumns()->mapWithKeys(function (
                ColumnInterface $column
            ) use ($row) {
                return [
                    $column->getName() => $column->setModel($row)->getValue(),
                ];
            });

            // whether this row has been soft deleted
            if ($this->getRepository()->isRestorable()) {
                $newRow->put('_deleted', $row->trashed() ? 1 : 0);
            }
            $newRow->put('_primary', $row->getKey());

            return $newRow;
        });
    }
}
