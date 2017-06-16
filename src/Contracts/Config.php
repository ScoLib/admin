<?php


namespace Sco\Admin\Contracts;

interface Config
{
    public function getOption($key, $default = null);
}
