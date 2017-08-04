<?php

namespace Sco\Admin\Form\Elements;

class Textarea extends Input
{
    protected $type = 'textarea';

    protected $rows = 2;

    public function getRows()
    {
        return $this->rows;
    }

    public function setRows($value)
    {
        $this->rows = $value;

        return $this;
    }

    public function toArray()
    {
        return parent::toArray() + [
                'rows' => $this->getRows()
            ];
    }
}
