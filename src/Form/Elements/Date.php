<?php

namespace Sco\Admin\Form\Elements;

use Carbon\Carbon;

class Date extends Input
{
    protected $type = 'date';

    /**
     * Date Picker format
     *
     * @var string
     */
    protected $pickerFormat = 'yyyy-MM-dd';

    /**
     * Datetime timezone.
     *
     * @var string
     */
    protected $timezone;

    protected $editable = false;

    public function getFormat()
    {
        return $this->convertPickerFormat();
    }

    /*public function setFormat($value)
    {
        $this->format = $value;

        return $this;
    }*/

    protected function convertPickerFormat()
    {
        return strtr($this->getPickerFormat(), [
            'yyyy' => 'Y',
            //'yy'   => 'y',
            'MM'   => 'm',
            //'M'    => 'n',
            'dd'   => 'd',
            //'d'    => 'j',
            'HH'   => 'H',
            //'H'    => 'G',
            'mm'   => 'i',
            'ss'   => 's',
        ]);
    }

    protected function getPickerFormat()
    {
        return $this->pickerFormat;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setPickerFormat($value)
    {
        $this->pickerFormat = $value;

        return $this;
    }

    /**
     * @return string
     */
    protected function getTimezone()
    {
        if ($this->timezone) {
            return $this->timezone;
        }

        return config('app.timezone');
    }

    /**
     * @param string $timezone
     *
     * @return $this
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    protected function isEditable()
    {
        return $this->editable;
    }

    /**
     * Allow edit
     *
     * @return $this
     */
    public function enableEdit()
    {
        $this->editable = true;

        return $this;
    }

    public function toArray()
    {
        return parent::toArray() + [
                //'format' => $this->getFormat(),
                'pickerFormat' => $this->getPickerFormat(),
                'editable' => $this->isEditable(),
            ];
    }

    protected function getDefaultValue()
    {
        return Carbon::now()
            ->timezone($this->getTimezone())
            ->format($this->getFormat());
    }

    public function getValue()
    {
        $value = parent::getValue();
        if (empty($value)) {
            return '';
        }
        return $this->dateToString($value);
    }

    protected function dateToString($value)
    {
        if (!($value instanceof Carbon)) {
            $value = Carbon::parse($value);
        }

        $value->timezone($this->getTimezone());

        return $value->format($this->getFormat());
    }

    protected function prepareValue($value)
    {
        $value = Carbon::parse($value);
        $value->timezone($this->getTimezone());
        return $value;
    }
}
