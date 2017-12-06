<?php

namespace Sco\Admin\View;

use Sco\Admin\Contracts\View\FilterFactoryInterface;
use Sco\Admin\Traits\AliasBinder;
use Sco\Admin\View\Filters\Checkbox;
use Sco\Admin\View\Filters\DateRange;
use Sco\Admin\View\Filters\DateTimeRange;
use Sco\Admin\View\Filters\Input;
use Sco\Admin\View\Filters\Radio;
use Sco\Admin\View\Filters\Select;

/**
 * @method static Radio radio()
 */
class FilterFactory implements FilterFactoryInterface
{
    use AliasBinder;

    public function __construct()
    {
        $this->registerAliases([
            'radio'         => Radio::class,
            'checkbox'      => Checkbox::class,
            'input'         => Input::class,
            'select'        => Select::class,
            'daterange'     => DateRange::class,
            'datetimerange' => DateTimeRange::class,
        ]);
    }
}
