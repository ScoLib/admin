<?php

namespace Sco\Admin\Form\Elements;

class Checkbox extends Select
{
    protected $type = 'checkbox';

    protected $max;
    protected $min = 0;

    public function getMax()
    {
        return $this->max;
    }

    public function setMax($value)
    {
        $this->max = (int)$value;

        $this->addValidationRule('max:' . $value);

        return $this;
    }

    public function getMin()
    {
        return $this->min;
    }

    public function setMin($value)
    {
        $this->min = (int)$value;

        $this->addValidationRule('min:' . $value);

        return $this;
    }

    protected function getDefaultValue()
    {
        return [];
    }

    public function toArray()
    {
        return parent::toArray() + [
                'min' => $this->getMin(),
                'max' => $this->getMax(),
            ];
    }
}
