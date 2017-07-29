<?php

namespace Sco\Admin\Contracts\Form;

use Illuminate\Database\Eloquent\Model;
use Sco\Admin\Contracts\Form\Elements\ElementInterface;

interface FormInterface
{
    /**
     * @return \Sco\Admin\Form\ElementsCollection
     */
    public function getElements();

    /**
     * @param array $elements
     *
     * @return $this
     */
    public function setElements(array $elements);

    /**
     * @param \Sco\Admin\Contracts\Form\Elements\ElementInterface $element
     *
     * @return $this
     */
    public function addElement(ElementInterface $element);

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return $this
     */
    public function setElementModel(Model $model);
}
