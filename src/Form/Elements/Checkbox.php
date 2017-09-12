<?php

namespace Sco\Admin\Form\Elements;

class Checkbox extends Select
{
    protected $type = 'checkbox';

    protected $max;
    protected $min          = 0;
    protected $showCheckAll = false;

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

    public function isShowCheckAll()
    {
        return $this->showCheckAll;
    }

    public function enableShowCheckAll()
    {
        $this->showCheckAll = true;

        return $this;
    }

    public function getValue()
    {
        $value = parent::getValue();
        if (empty($value)) {
            return [];
        }
        return explode(',', $value);
    }

    protected function getDefaultValue()
    {
        return [];
    }

    protected function prepareValue($value)
    {
        if (empty($value)) {
            return '';
        }

        return implode(',', $value);
    }

    public function toArray()
    {
        return parent::toArray() + [
                'min'          => $this->getMin(),
                'max'          => $this->getMax(),
                'showCheckAll' => $this->isShowCheckAll(),
            ];
    }
}
