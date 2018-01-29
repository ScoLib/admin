<?php

namespace Sco\Admin\Form\Elements;

/**
 * Form Element DateRange
 *
 * @package Sco\Admin\Form\Elements
 * @see http://element.eleme.io/#/en-US/component/date-picker
 */
class DateRange extends Date
{
    protected $type = 'daterange';

    protected $defaultValue = [];

    protected $pickerFormat = 'yyyy-MM-dd';

    protected $attributes = [];

    public function __construct($name, string $title)
    {
        $name = (array) $name;

        $this->attributes = $name;

        if (count($this->attributes) == 1) {
            $this->setCast('json');
        }

        parent::__construct(implode('_', $name), $title);
    }

    public function getValue()
    {
        $model = $this->getModel();
        $value = $this->getDefaultValue();
        if (is_null($model) || ! $model->exists) {
            return $value;
        }

        if (count($this->attributes) == 2) {
        } else {
            $value = $model->getAttribute(array_shift($this->attributes));
            if (($value = json_decode($value, true)) === false || is_null($value)) {
                $value = explode(',', $value);
            }
        }

        return [
            $this->dateToString($model->getAttribute($this->getStartName())),
            $this->dateToString($model->getAttribute($this->getEndName())),
        ];
    }

    protected function getDefaultValidationRules()
    {
        return [
            'array' => 'array',
        ];
    }

    public function save()
    {
        $model = $this->getModel();

        list($startValue, $endValue) = $this->getValueFromRequest();
        $model->setAttribute($this->getStartName(), $this->prepareValue($startValue));
        $model->setAttribute($this->getEndName(), $this->prepareValue($endValue));
    }
}
