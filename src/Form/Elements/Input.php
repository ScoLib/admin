<?php

namespace Sco\Admin\Form\Elements;

/**
 * Class Input
 *
 * @see http://element.eleme.io/#/en-US/component/input
 * @package Sco\Admin\Form\Elements
 */
abstract class Input extends NamedElement
{
    /**
     * @var
     */
    protected $maxLength;

    /**
     * @var int
     */
    protected $minLength = 0;

    /**
     * @var string
     */
    protected $size = '';

    /**
     * @var bool
     */
    protected $readonly = false;

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setSize(string $value)
    {
        $this->size = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function mediumSize()
    {
        return $this->setSize('medium');
    }

    /**
     * @return $this
     */
    public function smallSize()
    {
        return $this->setSize('small');
    }

    /**
     * @return $this
     */
    public function miniSize()
    {
        return $this->setSize('mini');
    }

    /**
     * @return mixed
     */
    public function getMaxLength()
    {
        return $this->maxLength;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setMaxLength(int $value)
    {
        $this->maxLength = $value;
        $this->addValidationRule('max:' . $value);

        return $this;
    }

    /**
     * @return int
     */
    public function getMinLength()
    {
        return $this->minLength;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setMinLength(int $value)
    {
        $this->minLength = $value;

        $this->addValidationRule('min:' . $value);

        return $this;
    }

    /**
     * @return bool
     */
    public function isReadonly()
    {
        return $this->readonly;
    }

    /**
     * @return $this
     */
    public function readonly()
    {
        $this->readonly = true;

        return $this;
    }

    public function toArray()
    {
        return parent::toArray() + [
                'minLength' => $this->getMinLength(),
                'maxLength' => $this->getMaxLength(),
                'size'      => $this->getSize(),
                'readonly'  => $this->isReadonly(),
            ];
    }
}
