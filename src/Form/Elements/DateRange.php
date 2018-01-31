<?php

namespace Sco\Admin\Form\Elements;

use Carbon\Carbon;

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
        if (count($this->attributes) == 1) {
            list($start, $end) = parent::getValue();
        } else {
            $model = $this->getModel();
            if (is_null($model) || ! $model->exists) {
                return [];
            }
            list($startName, $endName) = $this->attributes;
            $start = $model->getAttribute($startName);
            $end = $model->getAttribute($endName);
        }

        if ($start && $end) {
            return [
                $this->fromDateTime(Carbon::parse($start)),
                $this->fromDateTime(Carbon::parse($end)),
            ];
        }

        return [];
    }

    protected function getDefaultValidationRules()
    {
        return [
            'array' => 'array',
        ];
    }

    public function save()
    {
        if (count($this->attributes) == 1) {
            return parent::save();
        } else {
            $model = $this->getModel();
            list($startValue, $endValue) = $this->getValueFromRequest();
            list($startName, $endName) = $this->attributes;

            $model->setAttribute($startName, $this->prepareValue($startValue));
            $model->setAttribute($endName, $this->prepareValue($endValue));
        }
    }
}
