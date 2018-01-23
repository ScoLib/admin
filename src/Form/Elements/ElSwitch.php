<?php

namespace Sco\Admin\Form\Elements;

/**
 * Class ElSwitch
 *
 * @package Sco\Admin\Form\Elements
 * @see http://element.eleme.io/#/en-US/component/switch
 */
class ElSwitch extends NamedElement
{
    protected $type = 'elswitch';

    /**
     * Display Texts
     *
     * @var array
     */
    protected $texts = ['ON', 'OFF'];

    /**
     * Switch values.
     *
     * @var array
     */
    protected $values = ['1', '0'];

    /**
     * Background colors of display text.
     *
     * @var array
     */
    protected $colors = [];

    /**
     * class name of the icon displayed.
     *
     * @var array
     */
    protected $iconClasses = [];

    /**
     * width of Switch.
     *
     * @var int
     */
    protected $width = 40;

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setWidth(int $value)
    {
        $this->width = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param string|int $active
     * @param string|int $inactive
     *
     * @return ElSwitch
     */
    public function setValues($active, $inactive)
    {
        $this->values = [$active, $inactive];

        return $this;
    }

    /**
     * @return array
     */
    public function getTexts()
    {
        return $this->texts;
    }

    /**
     * @param string $active
     * @param string $inactive
     *
     * @return ElSwitch
     */
    public function setTexts(string $active, string $inactive)
    {
        $this->texts = [$active, $inactive];

        return $this;
    }

    /**
     * @return array
     */
    public function getColors()
    {
        return $this->colors;
    }

    /**
     * @param string $active
     * @param string $inactive
     *
     * @return ElSwitch
     */
    public function setColors(string $active, string $inactive)
    {
        $this->colors = [$active, $inactive];

        return $this;
    }

    /**
     * @return array
     */
    public function getIconClasses()
    {
        return $this->iconClasses;
    }

    /**
     * @param string $active
     * @param string $inactive
     *
     * @return $this
     */
    public function setIconClasses(string $active, string $inactive)
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
