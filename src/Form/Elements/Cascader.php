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
     * @var array
     */
    protected $names = [];

    /**
     *
     * @param array $names
     * @param string $title
     * @param string|array $options
     */
    public function __construct(array $names, $title, $options)
    {
        parent::__construct(implode('_', $names), $title);

        $this->names = $names;

        // TODO
    }
}
