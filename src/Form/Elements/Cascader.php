<?php

namespace Sco\Admin\Form\Elements;

/**
 * Class Cascader
 *
 * @package Sco\Admin\Form\Elements
 * @see http://element.eleme.io/#/en-US/component/cascader
 */
class Cascader extends Tree
{
    /**
     * @var string
     */
    protected $type = 'cascader';

    /**
     *
     * @param string|array $name
     * @param string $title
     * @param array|\Illuminate\Database\Eloquent\Model $options
     */
    public function __construct($name, string $title, $options = null)
    {
        parent::__construct(implode('_', $name), $title);


        // TODO
    }
}
