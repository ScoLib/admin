<?php

namespace Sco\Admin\Form\Elements;

use Illuminate\Validation\Rules\Unique;
use Sco\Admin\Contracts\Validatable;

abstract class NamedElement extends Element implements Validatable
{
    /**
     * @var string
     */
    protected $size = '';

    /**
     * @var bool
     */
    protected $disabled = false;

    /**
     * @var mixed
     */
    protected $defaultValue = '';

    /**
     * @var array
     */
    protected $validationRules = [];

    /**
     * @var array
     */
    protected $validationMessages = [];

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setSize(string $value)
    {
        $this->size = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function largeSize()
    {
        return $this->setSize('large');
    }

    /**
     * @return $this
     */
    public function mediumSize()
    {
        return $this->setSize('medium');
    }

    /**
     * @return $this
     */
    public function smallSize()
    {
        return $this->setSize('small');
    }

    /**
     * @return $this
     */
    public function miniSize()
    {
        return $this->setSize('mini');
    }

    /**
     * @return bool
     */
    public function isDisabled()
    {
        return $this->disabled;
    }

    /**
     * @return $this
     */
    public function disabled()
    {
        $this->disabled = true;

        return $this;
    }

    /**
     * @param null|string $message
     * @return $this
     */
    public function required($message = null)
    {
        $this->addValidationRule('required', $message);

        return $this;
    }

    /**
     * @param null|string $message
     * @return $this
     */
    public function unique($message = null)
    {
        $this->addValidationRule('unique', $message);

        return $this;
    }

    /**
     * @return array
     */
    public function getValidationRules()
    {
        $rules = array_merge(
            $this->getDefaultValidationRules(),
            $this->validationRules
        );

        if (isset($rules['unique']) && $rules['unique'] == 'unique') {
            $model = $this->getModel();
            $table = $model->getTable();

            $rule = new Unique($table, $this->getName());
            if ($model->exists) {
                $rule->ignore($model->getKey(), $model->getKeyName());
            }

            $rules['unique'] = $rule;
        }

        return [$this->getName() => array_values($rules)];
    }

    /**
     * @return array
     */
    protected function getDefaultValidationRules()
    {
        return [
            'bail' => 'bail',
        ];
    }

    /**
     * @return array
     */
    public function getValidationMessages()
    {
        return $this->validationMessages;
    }

    /**
     * Get validation custom attributes
     *
     * @return array
     */
    public function getValidationTitles()
    {
        return [$this->getName() => $this->getTitle()];
    }

    /**
     * @param $rule
     * @param null $message
     * @return $this
     */
    public function addValidationRule($rule, $message = null)
    {
        $this->validationRules[$this->getValidationRuleName($rule)] = $rule;

        if (is_null($message)) {
            return $this;
        }

        return $this->addValidationMessage($rule, $message);
    }

    /**
     * @param $rule
     * @param $message
     * @return $this
     */
    public function addValidationMessage($rule, $message)
    {
        $key = $this->getName() . '.' . $this->getValidationRuleName($rule);

        $this->validationMessages[$key] = $message;

        return $this;
    }

    /**
     * @param $rule
     * @return mixed
     */
    protected function getValidationRuleName(string $rule)
    {
        list($name,) = explode(':', $rule, 2);

        return $name;
    }

    public function toArray()
    {
        return parent::toArray() + [
                'size'     => $this->getSize(),
                'disabled' => $this->isDisabled(),
            ];
    }
}
