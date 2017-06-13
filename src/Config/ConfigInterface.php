<?php


namespace Sco\Admin\Config;

interface ConfigInterface
{
    public function getOption($key, $default = null);
}
