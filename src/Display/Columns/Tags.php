<?php

namespace Sco\Admin\Display\Columns;

class Tags extends Column
{
    protected $template = '<p><el-tag type="primary" :key="item" v-for="item in value">{{ item }}</el-tag></p>';
}
