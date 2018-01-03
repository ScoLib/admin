<?php

namespace Sco\Admin\View;

use Illuminate\Support\Collection;
use InvalidArgumentException;

class Tree extends View
{
    protected $type = 'tree';

    protected $titleAttribute;

    public function get()
    {
        $builder = $this->getQuery();

        return $this->getTree($builder->get());
    }

    public function getTitleAttribute()
    {
        return $this->titleAttribute;
    }

    public function setTitleAttribute($value)
    {
        $this->titleAttribute = $value;

        return $this;
    }

    public function getTree(Collection $collection)
    {
        if (is_null($key = $this->getTitleAttribute())) {
            throw new InvalidArgumentException('Must set Tree title attribute');
        }

        return $collection->map(function ($row) use ($key) {
            if (! isset($row->$key)) {
                throw new \InvalidArgumentException("Not Found '{$key}' attribute");
            }

            return [
                'title'    => $row->$key,
                'children' => [],
                '_primary' => $row->getKey(),
            ];
        });
    }
}
