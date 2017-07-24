<?php

namespace Sco\Admin\View\Columns;

class Lists extends Column
{
    protected $template = '<p><span class="label label-info" v-for="item in value">{{ item }}</span></p>';

}
