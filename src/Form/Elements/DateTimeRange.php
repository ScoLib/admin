<?php

namespace Sco\Admin\Form\Elements;

class DateTimeRange extends Date
{
    protected $type = 'datetimerange';

    protected $startName;

    protected $endName;

    public function __construct($startName, $endName, $title)
    {
        $this->startName = $startName;
        $this->endName   = $endName;

        parent::__construct('', $title);
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
            $model->getAttribute($this->getStartName()),
            $model->getAttribute($this->getEndName()),
        ];
    }
}
