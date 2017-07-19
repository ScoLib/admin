<?php

namespace Sco\Admin\Contracts;

interface WithNavigation
{
    public function addToNavigation($priority = 100, $badge = null);
}
