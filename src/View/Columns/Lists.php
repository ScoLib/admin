<?php

namespace Sco\Admin\View\Columns;

class Lists extends Column
{
    protected $template = '<p><el-tag type="primary" :key="item" v-for="item in value">{{ item }}</el-tag></p>';
}
