<?php

namespace Sco\Admin\View\Columns;

class Html extends Column
{
    protected $template = '<span v-html="value"></span>';
}
