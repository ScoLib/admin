<?php

namespace Sco\Admin\Contracts\View;

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
    public function getName();

    public function setWidth($width);

    public function setMinWidth($width);

    public function isSortable();

    public function isCustomSortable();

    public function isFixed();

    public function getValue();

    public function getTemplate();

    /**
     * @param string $template
     *
     * @return $this
     */
    public function setTemplate($template);
}
