<?php

namespace Sco\Admin\Form;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Sco\Admin\Contracts\Form\Elements\ElementInterface;
use Sco\Admin\Contracts\Form\FormInterface;
use Sco\Admin\Contracts\Validatable;
use Validator;

class Form implements
    FormInterface,
    Validatable
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
    public function getElement($name)
    {
        $key = $this->getElements()->search(function (ElementInterface $item) use ($name
        ) {
            return $item->getName() == $name;
        });
        if ($key === false) {
            throw new InvalidArgumentException('Not found element');
        }

        return $this->getElements()->get($key);
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
    public function validate()
    {
        Validator::validate(
            request()->all(),
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
        $rules = [];
        $this->elements->each(function (ElementInterface $element) use (&$rules) {
            if ($element instanceof Validatable) {
                $rules += $element->getValidationRules();
            }
        });

        return $rules;
    }

    protected function getElementsValidationMessages()
    {
        $messages = [];
        $this->elements->each(function (ElementInterface $element) use (&$messages) {
            if ($element instanceof Validatable) {
                $messages += $element->getValidationMessages();
            }
        });

        return $messages;
    }

    protected function getElementsValidationTitles()
    {
        $titles = [];
        $this->elements->each(function (ElementInterface $element) use (&$titles) {
            if ($element instanceof Validatable) {
                $titles += $element->getValidationTitles();
            }
        });

        return $titles;
    }

    protected function saveElements()
    {
        $this->getElements()->each(function (ElementInterface $element) {
            $element->save();
        });
    }

    protected function finishSaveElements()
    {
        $this->getElements()->each(function (ElementInterface $element) {
            $element->finishSave();
        });
    }

    protected function finishSave()
    {
        $this->finishSaveElements();
    }

    public function save()
    {
        $this->saveElements();

        $model = $this->getModel();
        $saved = $model->save();

        if ($saved) {
            $this->finishSave();
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getValues()
    {
        return $this->elements->mapWithKeys(function (ElementInterface $element) {
            return [
                $element->getName() => $element->getValue(),
            ];
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
