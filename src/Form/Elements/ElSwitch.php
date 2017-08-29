<?php

namespace Sco\Admin\Form\Elements;

class ElSwitch extends NamedElement
{
    protected $type = 'elswitch';

    protected $text      = ['ON', 'OFF'];
    protected $values    = ['yes', 'no'];
    protected $color     = [];
    protected $iconClass = [];

    protected $width = 58;

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($value)
    {
        $this->width = intval($value);

        return $this;
    }

    public function getValues()
    {
        return $this->values;
    }

    public function setValues($on, $off)
    {
        $this->values = [$on, $off];

        return $this;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($on, $off)
    {
        $this->text = [$on, $off];

        return $this;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($on, $off)
    {
        $this->color = [$on, $off];

        return $this;
    }

    public function getIconClass()
    {
        return $this->iconClass;
    }

    public function setIconClass($on, $off)
    {
        $this->iconClass = [$on, $off];

        return $this;
    }

    public function toArray()
    {
        return parent::toArray() + [
                'text'      => $this->getText(),
                'values'    => $this->getValues(),
                'color'     => $this->getColor(),
                'iconClass' => $this->getIconClass(),
                'width'     => $this->getWidth(),
            ];
    }
}
