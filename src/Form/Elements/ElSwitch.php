<?php

namespace Sco\Admin\Form\Elements;

class ElSwitch extends NamedElement
{
    protected $type = 'elswitch';

    protected $text      = ['ON', 'OFF'];
    protected $values    = ['yes', 'no'];
    protected $color     = [];
    protected $iconClass = [];

    protected $width = 40;

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

    public function setValues($active, $inactive)
    {
        $this->values = [$active, $inactive];

        return $this;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($active, $inactive)
    {
        $this->text = [$active, $inactive];

        return $this;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($active, $inactive)
    {
        $this->color = [$active, $inactive];

        return $this;
    }

    public function getIconClass()
    {
        return $this->iconClass;
    }

    public function setIconClass($active, $inactive)
    {
        $this->iconClass = [$active, $inactive];

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
