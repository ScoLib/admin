<?php


namespace Sco\Admin\Column;

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
        $this->setAttribute($column['key'], new $columnClass($column));
    }
}
