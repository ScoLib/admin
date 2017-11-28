<?php

namespace Sco\Admin\Form\Elements;

/**
 * Form Element DateTime
 *
 * @see http://element.eleme.io/#/zh-CN/component/datetime-picker
 */
class DateTime extends Date
{
    protected $type = 'datetime';

    protected $pickerFormat = 'yyyy-MM-dd HH:mm:ss';
}
