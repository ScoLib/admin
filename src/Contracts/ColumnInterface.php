<?php

namespace Sco\Admin\Contracts;

interface ColumnInterface
{
    public function getName();

    public function setWidth($width);

    public function setMinWidth($width);

    public function isSortable();

    public function isCustomSortable();

    public function isFixed();
}
