<?php

namespace Sco\Admin\Form\Elements;

/**
 * Checkbox
 *
 * @see http://element.eleme.io/#/zh-CN/component/checkbox
 */
class Checkbox extends MultiSelect
{
    protected $type = 'checkbox';

    protected $defaultValue = [];

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

    public function toArray()
    {
        return parent::toArray() + [
                'min'          => $this->getMin(),
                'max'          => $this->getMax(),
                'showCheckAll' => $this->isShowCheckAll(),
            ];
    }
}
