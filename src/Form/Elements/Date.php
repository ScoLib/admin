<?php

namespace Sco\Admin\Form\Elements;

use Carbon\Carbon;

/**
 * Form Element Date
 *
 * @package Sco\Admin\Form\Elements
 * @see http://element.eleme.io/#/en-US/component/date-picker
 */
class Date extends Input
{
    protected $type = 'date';

    protected $cast = 'date';

    protected $defaultValue = '';

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

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->convertPickerFormat();
    }

    /**
     * @return string
     */
    protected function convertPickerFormat()
    {
        return strtr($this->getPickerFormat(), [
            'yyyy' => 'Y',
            'MM'   => 'm',
            'dd'   => 'd',
            'HH'   => 'H',
            'mm'   => 'i',
            'ss'   => 's',
        ]);
    }

    /**
     * @return string
     */
    protected function getPickerFormat()
    {
        return $this->pickerFormat;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setPickerFormat(string $value)
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
    public function setTimezone(string $timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * @return bool
     */
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
                'editable'     => $this->isEditable(),
            ];
    }

    /**
     * Return a timestamp as DateTime object.
     *
     * @param  mixed $value
     * @return Carbon
     */
    protected function asDateTime($value)
    {
        if ($value instanceof Carbon) {
            return $value->timezone($this->getTimezone());
        }

        if ($value instanceof \DateTimeInterface) {
            return new Carbon(
                $value->format('Y-m-d H:i:s.u'),
                $value->getTimezone()
            );
        }

        if (is_numeric($value)) {
            return Carbon::createFromTimestamp($value)->timezone($this->getTimezone());
        }

        return Carbon::createFromFormat($this->getFormat(), $value);
    }

    /**
     * Convert a DateTime to a storable string.
     *
     * @param  \DateTime|int $value
     * @return string
     */
    public function fromDateTime($value)
    {
        return empty($value) ? $value : $this->asDateTime($value)
            ->timezone($this->getTimezone())
            ->format($this->getFormat());
    }
}
