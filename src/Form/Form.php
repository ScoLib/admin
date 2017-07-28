<?php

namespace Sco\Admin\Form;

use Sco\Admin\Contracts\Form\Elements\ElementInterface;
use Sco\Admin\Contracts\Form\FormInterface;

class Form implements FormInterface
{
    protected $elements;

    public function __construct(array $elements = [])
    {
        $this->setElements($elements);
    }

    public function setElements(array $elements)
    {
        $this->elements = new ElementsCollection($elements);

        return $this;
    }

    /**
     * @param \Sco\Admin\Contracts\Form\Elements\ElementInterface $element
     *
     * @return $this
     */
    public function addElement(ElementInterface $element)
    {
        $this->elements->push($element);

        return $this;
    }
}
