<?php

namespace Sco\Admin\Form\Elements;

/**
 * Form Element Time
 *
 * @see http://element.eleme.io/#/zh-CN/component/time-picker
 */
class Time extends Date
{
    protected $type = 'time';

    protected $cast = 'time';

    protected $pickerFormat = 'HH:mm:ss';
}
