<?php

namespace Sco\Admin\Form\Elements;

class ElSwitch extends NamedElement
{
    protected $type = 'elswitch';

    protected $texts       = ['ON', 'OFF'];
    protected $values      = ['1', '0'];
    protected $colors      = [];
    protected $iconClasses = [];

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

    /**
     * @param $active
     * @param $inactive
     *
     * @return ElSwitch
     */
    public function setValues($active, $inactive)
    {
        $this->values = [$active, $inactive];

        return $this;
    }

    public function getTexts()
    {
        return $this->texts;
    }

    /**
     * @param $active
     * @param $inactive
     *
     * @return ElSwitch
     */
    public function setTexts($active, $inactive)
    {
        $this->texts = [$active, $inactive];

        return $this;
    }

    public function getColors()
    {
        return $this->colors;
    }

    /**
     * @param $active
     * @param $inactive
     *
     * @return ElSwitch
     */
    public function setColors($active, $inactive)
    {
        $this->colors = [$active, $inactive];

        return $this;
    }

    public function getIconClasses()
    {
        return $this->iconClasses;
    }

    public function setIconClasses($active, $inactive)
    {
        $this->iconClasses = [$active, $inactive];

        return $this;
    }

    public function toArray()
    {
        return parent::toArray() + [
                'texts'       => $this->getTexts(),
                'values'      => $this->getValues(),
                'colors'      => $this->getColors(),
                'iconClasses' => $this->getIconClasses(),
                'width'       => $this->getWidth(),
            ];
    }
}
