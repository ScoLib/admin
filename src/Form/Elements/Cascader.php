<?php

namespace Sco\Admin\Form\Elements;

class Cascader extends Element
{
    protected $type = 'cascader';

    public function __construct($name, $title, $options)
    {
        parent::__construct($name, $title);

        $this->setOptions($options);
    }
}
