<?php

namespace Sco\Admin\Display;

use Sco\Admin\Contracts\Display\FilterFactoryInterface;
use Sco\Admin\Traits\AliasBinder;
use Sco\Admin\Display\Filters\Checkbox;
use Sco\Admin\Display\Filters\DateRange;
use Sco\Admin\Display\Filters\DateTimeRange;
use Sco\Admin\Display\Filters\Text;
use Sco\Admin\Display\Filters\Radio;
use Sco\Admin\Display\Filters\Select;

/**
 * @method static Text text($name, $title) input form
 * @method static Radio radio($name, $title, $options = null) radio form
 * @method static Select select($name, $title, $options = null) select form
 * @method static Checkbox checkbox($name, $title, $options = null) checkbox form
 * @method static DateRange daterange($name, $title)
 * @method static DateTimeRange datetimerange($name, $title)
 */
class FilterFactory implements FilterFactoryInterface
{
    use AliasBinder;

    public function __construct()
    {
        $this->register([
            'radio'         => Radio::class,
            'checkbox'      => Checkbox::class,
            'text'          => Text::class,
            'select'        => Select::class,
            'daterange'     => DateRange::class,
            'datetimerange' => DateTimeRange::class,
        ]);
    }
}
