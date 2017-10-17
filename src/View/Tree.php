<?php

namespace Sco\Admin\View;

class Tree extends View
{
    protected $type = 'tree';

    public function get()
    {
        $builder = $this->getQuery();
        return $builder->get();
    }
}
