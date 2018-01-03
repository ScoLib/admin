<?php

namespace Sco\Admin\Form\Elements;

use Carbon\Carbon;

class Timestamp extends DateTime
{
    protected function dateToString($value)
    {
        $value = Carbon::createFromTimestamp($value);

        $value->timezone($this->getTimezone());

        return $value->format($this->getFormat());
    }

    /**
     * @param mixed $value
     *
     * @return int
     */
    protected function prepareValue($value)
    {
        $value = parent::prepareValue($value);

        return $value->getTimestamp();
    }
}
