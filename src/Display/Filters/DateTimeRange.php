<?php

namespace Sco\Admin\Display\Filters;

class DateTimeRange extends DateRange
{
    protected $type = 'datetimerange';

    protected $pickerFormat = 'yyyy-MM-dd HH:mm:ss';

    protected $defaultValue = [];
}
