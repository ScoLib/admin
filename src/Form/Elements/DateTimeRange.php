<?php

namespace Sco\Admin\Form\Elements;

/**
 * Form Element DateTime
 *
 * @package Sco\Admin\Form\Elements
 * @see http://element.eleme.io/#/en-US/component/datetime-picker
 */
class DateTimeRange extends DateRange
{
    protected $type = 'datetimerange';

    protected $pickerFormat = 'yyyy-MM-dd HH:mm:ss';
}
