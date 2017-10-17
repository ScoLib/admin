<?php

namespace Sco\Admin\View;

class Image extends View
{
    protected $type = 'image';

    public function get()
    {
        $builder = $this->getQuery();
        return $builder->get();
    }
}
