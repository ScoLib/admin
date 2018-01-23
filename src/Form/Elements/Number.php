<?php

namespace Sco\Admin\Form\Elements;

class Number extends NamedElement
{
    protected $type = 'number';

    protected $max;

    protected $min = 0;

    protected $step = 1;

    /**
     * @return string|int
     */
    public function getMax()
    {
        if ($this->max) {
            return $this->max;
        }

        return $this->getDefaultMax();
    }

    protected function getDefaultMax()
    {
        return 'Infinity';
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setMax(int $value)
    {
        $this->max = $value;

        $this->addValidationRule('max:' . $value);

        return $this;
    }

    /**
     * @return int
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setMin(int $value)
    {
        $this->min = $value;

        $this->addValidationRule('min:' . $value);

        return $this;
    }

    /**
     * @return int
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setStep(int $value)
    {
        $this->step = $value;

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
                'step' => $this->getStep(),
            ];
    }
}
