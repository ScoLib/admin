<?php

namespace Sco\Admin\Form\Elements;

use Illuminate\Http\Request;

class DateRange extends Date
{
    protected $type = 'daterange';

    protected $pickerFormat = 'yyyy-MM-dd';

    protected $startName;

    protected $endName;

    public function __construct($startName, $endName, $title)
    {
        $this->startName = $startName;
        $this->endName   = $endName;

        parent::__construct('', $title);
    }

    public function getName()
    {
        return $this->getStartName() . '_' . $this->getEndName();
    }

    public function getStartName()
    {
        return $this->startName;
    }

    public function getEndName()
    {
        return $this->endName;
    }

    public function getDefaultValue()
    {
        return [];
    }

    public function getValue()
    {
        $model = $this->getModel();
        $value = $this->getDefaultValue();
        if (is_null($model) || !$model->exists) {
            return $value;
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

    public function save(Request $request)
    {
        $model = $this->getModel();

        list($startValue, $endValue) = $this->getValueFromRequest($request);
        $model->setAttribute($this->getStartName(), $this->prepareValue($startValue));
        $model->setAttribute($this->getEndName(), $this->prepareValue($endValue));
    }
}
