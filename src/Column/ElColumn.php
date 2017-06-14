<?php


namespace Sco\Admin\Column;

use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;


class ElColumn extends Column implements ColumnInterface, Arrayable, Jsonable, JsonSerializable
{

    protected $defaults = [
        'fixed' => false,
    ];

}
