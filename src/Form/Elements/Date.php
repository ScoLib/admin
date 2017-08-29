<?php

namespace Sco\Admin\Form\Elements;

class Date extends Input
{
    protected $type = 'date';

    protected $format = 'yyyy-MM-dd';

    public function getFormat()
    {
        return $this->format;
    }

    public function setFormat($value)
    {
        $this->format = $value;

        return $this;
    }

    protected function getDefaultValue()
    {
        return date('Y-m-d');
    }

    public function toArray()
    {
        return parent::toArray() + [
                'format' => $this->getFormat(),
            ];
    }
}
