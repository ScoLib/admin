<?php


namespace Sco\Admin\Column;

use Sco\Attributes\HasAttributesTrait;

abstract class Column
{
    use HasAttributesTrait;

    public function __construct($option)
    {
        $this->setAttribute($option);
    }

    function __toString()
    {
        return $this->toJson();
    }
}
