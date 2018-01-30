<?php

namespace Sco\Admin\Form\Elements;

/**
 * Form Element DateTime
 *
 * @package Sco\Admin\Form\Elements
 * @see http://element.eleme.io/#/en-US/component/datetime-picker
 */
class DateTime extends Date
{
    protected $type = 'datetime';

    protected $cast = 'datetime';

    protected $pickerFormat = 'yyyy-MM-dd HH:mm:ss';
}
