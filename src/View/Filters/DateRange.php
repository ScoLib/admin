<?php

namespace Sco\Admin\View\Filters;

class DateRange extends Filter
{
    protected $type = 'daterange';

    protected $pickerFormat = 'yyyy-MM-dd';

    protected $defaultValue = [];

    protected $operator = 'between';

    /**
     * @return string
     */
    public function getPickerFormat(): string
    {
        return $this->pickerFormat;
    }

    /**
     * @param string $pickerFormat
     *
     * @return DateRange
     */
    public function setPickerFormat(string $pickerFormat): DateRange
    {
        $this->pickerFormat = $pickerFormat;

        return $this;
    }

    public function toArray()
    {
        return parent::toArray() + [
                'pickerFormat' => $this->getPickerFormat(),
            ];
    }
}
