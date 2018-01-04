<?php

namespace Sco\Admin\Display\Columns;

use Carbon\Carbon;

class DateTime extends Column
{

    /**
     * Datetime format.
     *
     * @var string
     */
    protected $format;

    /**
     * Datetime timezone.
     *
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
     * @param string $format
     *
     * @return DateTime
     */
    public function setFormat(string $format)
    {
        $this->format = $format;

        return $this;
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
     * @param string $timezone
     *
     * @return DateTime
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function getValue()
    {
        $value = parent::getValue();

        return $this->getFormatValue($value);
    }

    protected function getFormatValue($date)
    {
        if (! empty($date)) {
            if (is_numeric($date)) {
                $date = Carbon::createFromTimestamp($date);
            }
            if (! ($date instanceof Carbon)) {
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
