<?php


namespace Sco\Admin\View\Columns;

use Carbon\Carbon;

class DateTime extends Column
{

    /**
     * Datetime format.
     * @var string
     */
    protected $format;

    /**
     * Datetime timezone.
     * @var string
     */
    protected $timezone;

    /**
     * @return string
     */
    public function getFormat()
    {
        if ($this->format) {
            return $this->format;
        }

        return config('admin.datetime_format');
    }

    /**
     * @return string
     */
    public function getTimezone()
    {
        if ($this->timezone) {
            return $this->timezone;
        }

        return config('app.timezone');
    }

    /**
     * @param string $format
     *
     * @return $this
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
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

    public function getModelValue()
    {
        $value = parent::getModelValue();
        return $this->getFormatValue($value);
    }

    protected function getFormatValue($date)
    {
        if (!is_null($date)) {
            if (!$date instanceof Carbon) {
                $date = Carbon::parse($date);
            }

            $date->timezone($this->getTimezone());

            if ($this->getFormat() == 'humans') {
                $date = $date->diffForHumans();
            } else {
                $date = $date->format($this->getFormat());
            }
        }

        return $date;
    }
}
