<?php

namespace Sco\Admin\Form\Elements;

class NamedElement extends Element
{
    public function required($message = null)
    {
        $this->addValidationRule('required', $message);
        return $this;
    }

    public function unique($message = null)
    {
        $this->addValidationRule('_unique');

        if (!is_null($message)) {
            $this->addValidationMessage('unique', $message);
        }

        return $this;
    }

    public function getValidationRules()
    {
        $rules = parent::getValidationRules();

        foreach ($rules as &$rule) {
            if ($rule !== '_unique') {
                continue;
            }

            $model = $this->getModel();
            $table = $model->getTable();

            $rule = 'unique:'.$table.','.$this->getName();
            if ($model->exists) {
                $rule .= ','.$model->getKey();
            }
        }
        unset($rule);

        return [$this->getName() => $rules];
    }

    /**
     * @return array
     */
    public function getValidationMessages()
    {
        $messages = parent::getValidationMessages();

        foreach ($messages as $rule => $message) {
            $messages[$this->getName().'.'.$rule] = $message;
            unset($messages[$rule]);
        }

        return $messages;
    }
}
