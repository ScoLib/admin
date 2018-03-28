<?php

namespace Sco\Admin\Contracts\Display;

use Sco\Admin\Contracts\WithModel;
use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

interface ColumnInterface extends
    WithModel,
    Arrayable,
    Jsonable,
    JsonSerializable
{
    public function getType();

    public function getName();

    /**
     * @param string $name
     *
     * @return Column
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getLabel();

    /**
     * @param string $label
     *
     * @return Column
     */
    public function setLabel(string $label);

    public function getWidth();

    public function setWidth(int $width);

    public function getMinWidth();

    public function setMinWidth(int $width);

    public function getSortable();

    public function sortable();

    public function enableFixed();

    public function getValue();

    public function setDefaultValue($value);

    public function getDefaultValue();
}
