<?php


namespace Sco\Admin\Column;

use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Sco\Admin\Contracts\Column\Column as ColumnContract;

class ElColumn extends Column implements ColumnContract, Arrayable, Jsonable, JsonSerializable
{
    protected $defaults = [
        'minWidth' => '100',
        'fixed'    => false,
    ];

    public function toArray()
    {
        $column = [
            'fixed'    => $this->getAttribute('fixed'),
            'minWidth' => $this->getAttribute('minWidth'),
        ];

        return array_merge(parent::toArray(), $column);
    }
}
