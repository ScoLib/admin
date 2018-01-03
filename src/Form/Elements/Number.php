<?php

namespace Sco\Admin\Form\Elements;

class Number extends NamedElement
{
    protected $type = 'number';

    protected $max;

    protected $min = 0;

    protected $step = 1;

    public function getMax()
    {
        return $this->max;
    }

    public function setMax($value)
    {
        $this->max = (int) $value;

        $this->addValidationRule('max:' . $value);

        return $this;
    }

    public function getMin()
    {
        return $this->min;
    }

    public function setMin($value)
    {
        $this->min = (int) $value;

        $this->addValidationRule('min:' . $value);

        return $this;
    }

    public function setStep($value)
    {
        $this->step = (int) $value;

        return $this;
    }

    protected function getDefaultValidationRules()
    {
        return parent::getDefaultValidationRules() + [
                'numeric' => 'numeric'
            ];
    }

    public function toArray()
    {
        return parent::toArray() + [
                'min'  => $this->getMin(),
                'max'  => $this->getMax(),
                'step' => $this->step,
            ];
    }
}
