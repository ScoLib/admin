<?php

namespace Sco\Admin\Form;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Model;
use JsonSerializable;
use Sco\Admin\Contracts\Form\Elements\ElementInterface;
use Sco\Admin\Contracts\Form\FormInterface;
use Sco\Admin\Contracts\Validable;
use Sco\Admin\Contracts\WithModel;

class Form implements
    FormInterface,
    WithModel,
    Jsonable,
    Arrayable,
    JsonSerializable,
    Validable
{
    /**
     * @var \Sco\Admin\Form\ElementsCollection
     */
    protected $elements;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function __construct(array $elements = [])
    {
        $this->setElements($elements);
    }

    /**
     * {@inheritdoc}
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * {@inheritdoc}
     */
    public function setElements(array $elements)
    {
        $this->elements = new ElementsCollection($elements);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addElement(ElementInterface $element)
    {
        $this->elements->push($element);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * {@inheritdoc}
     */
    public function setModel(Model $model)
    {
        $this->model = $model;

        $this->setElementModel($model);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setElementModel(Model $model)
    {
        $this->elements->each(function (ElementInterface $element) use ($model) {
            //if ($element instanceof WithModel) {
            $element->setModel($model);
            //}
        });

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(array $data = [])
    {
        $data = empty($data) ? request()->all() : $data;
        \Validator::validate(
            $data,
            $this->getValidationRules(),
            $this->getValidationMessages(),
            $this->getValidationTitles()
        );

        return $this;
    }

    public function getValidationRules()
    {
        return $this->getElementsValidationRules();
    }

    public function getValidationMessages()
    {
        return $this->getElementsValidationMessages();
    }

    public function getValidationTitles()
    {
        return $this->getElementsValidationTitles();
    }

    protected function getElementsValidationRules()
    {
        return $this->elements->mapWithKeys(function (ElementInterface $element) {
            if ($element instanceof Validable) {
                return $element->getValidationRules();
            }
        });
    }

    public function save()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getValues()
    {
        return $this->elements->mapWithKeys(function (ElementInterface $element) {
            return [$element->getName() => $element->getValue()];
        });
    }

    public function toArray()
    {
        return [
            'elements' => $this->getElements(),
            'values'   => $this->getValues(),
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    public function __toString()
    {
        return $this->toJson();
    }
}
