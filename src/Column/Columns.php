<?php


namespace Sco\Admin\Column;

use Illuminate\Database\Eloquent\Model;
use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Sco\Admin\Contracts\Column\Columns as ColumnsContract;
use Sco\Attributes\HasAttributesTrait;

class Columns implements ColumnsContract, Arrayable, Jsonable, JsonSerializable
{
    use HasAttributesTrait;

    public function __construct(array $columns)
    {
        foreach ($columns as $column) {
            $this->addColumn($column);
        }
    }

    public function addColumn($column)
    {
        $columnClass = config('admin.column');
        $this->attributes[] = new $columnClass($column);
    }

    public function parseRow(Model $model)
    {
        foreach ($this->getAttributes() as $column) {
            var_dump($column->parseData($model));
        }
    }
}
