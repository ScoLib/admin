<?php

namespace Sco\Admin\Form\Elements;

class Hidden extends Input
{
    protected $type = 'hidden';

    public function __construct(string $name)
    {
        parent::__construct($name, '');
    }
}
