<?php

namespace Sco\Admin\Form\Elements;

class Hidden extends Input
{
    protected $type = 'hidden';

    public function __construct($name)
    {
        parent::__construct($name, '');
    }
}
