<?php

namespace Sco\Admin\Form\Elements;

use Sco\Admin\Contracts\Validatable;

class NamedElement extends Element implements Validatable
{
    protected $defaultValue = '';

    protected $validationRules = ['bail'];

    protected $validationMessages = [];

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
        $rules = $this->validationRules;

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
        $messages = $this->validationMessages;

        foreach ($messages as $rule => $message) {
            $messages[$this->getName().'.'.$rule] = $message;
            unset($messages[$rule]);
        }

        return $messages;
    }

    public function getValidationTitles()
    {
        return [$this->getName() => $this->getTitle()];
    }

    public function addValidationRule($rule, $message = null)
    {
        $this->validationRules[] = $rule;

        if (is_null($message)) {
            return $this;
        }

        return $this->addValidationMessage($rule, $message);
    }

    public function addValidationMessage($rule, $message)
    {
        if (($pos = strpos($rule, ':')) !== false) {
            $rule = substr($rule, 0, $pos);
        }

        $this->validationMessages[$rule] = $message;

        return $this;
    }
}
