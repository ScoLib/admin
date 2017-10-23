<?php

namespace Sco\Admin\View;

use Illuminate\Support\Collection;

class Tree extends View
{
    protected $type = 'tree';

    public function get()
    {
        $builder = $this->getQuery();
        return $this->getTree($builder->get());
    }

    public function getTree(Collection $collection)
    {
        return $collection->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->name,
                'children' => [],
            ];
        });
    }
}
