<?php

namespace Sco\Admin\Form\Elements;

/**
 * Class Checkbox
 *
 * @package Sco\Admin\Form\Elements
 * @see http://element.eleme.io/#/en-US/component/checkbox
 */
class Checkbox extends MultiSelect
{
    protected $type = 'checkbox';

    /**
     * maximum number of checkbox checked
     *
     * @var int|null
     */
    protected $max;

    /**
     * minimum number of checkbox checked
     *
     * @var int
     */
    protected $min = 0;

    /**
     * If show check all button.
     *
     * @var bool
     */
    protected $showCheckAll = false;

    /**
     * Get maximum number.
     *
     * @return int|null
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * Set maximum number.
     *
     * @param int $value
     *
     * @return $this
     */
    public function setMax(int $value)
    {
        $this->max = $value;

        $this->addValidationRule('max:' . $value);

        return $this;
    }

    /**
     * Get minimum number.
     *
     * @return int
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * Set minimum number.
     *
     * @param int $value
     *
     * @return $this
     */
    public function setMin(int $value)
    {
        $this->min = $value;

        $this->addValidationRule('min:' . $value);

        return $this;
    }

    /**
     * Determine if show check all button.
     *
     * @return bool
     */
    public function isShowCheckAll()
    {
        return $this->showCheckAll;
    }

    /**
     * Show check all button.
     *
     * @return $this
     */
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
