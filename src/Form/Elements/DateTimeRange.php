<?php

namespace Sco\Admin\Form\Elements;

/**
 * Form Element DateTime
 *
 * @see http://element.eleme.io/#/zh-CN/component/datetime-picker
 */
class DateTimeRange extends DateRange
{
    protected $type = 'datetimerange';

    protected $pickerFormat = 'yyyy-MM-dd HH:mm:ss';
}
