<?php

namespace Sco\Admin\Display\Filters;

class Checkbox extends Select
{
    protected $type = 'checkbox';

    protected $defaultValue = [];

    protected $operator = 'in';
}
