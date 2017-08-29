<?php

namespace Sco\Admin\Form\Elements;

class DateTime extends Date
{
    protected $type = 'datetime';

    protected $format = 'yyyy-MM-dd HH:mm:ss';

    protected function getDefaultValue()
    {
        return date('Y-m-d H:i:s');
    }
}
