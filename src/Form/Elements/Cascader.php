<?php

namespace Sco\Admin\Form\Elements;

/**
 * Cascader
 *
 * @see http://element.eleme.io/#/zh-CN/component/cascader
 */
class Cascader extends Tree
{
    protected $type = 'cascader';

    protected $names = [];

    public function __construct(array $names, $title, $options)
    {
        parent::__construct(implode('_', $names), $title);

        $this->names = $names;
    }
}
