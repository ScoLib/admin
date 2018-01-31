<?php

namespace Sco\Admin\Display;

use Sco\Admin\Contracts\Display\DisplayFactoryInterface;
use Sco\Admin\Traits\AliasBinder;

/**
 * @method static Table table()
 * @method static Image image()
 */
class DisplayFactory implements DisplayFactoryInterface
{
    use AliasBinder;

    public function __construct()
    {
        $this->register([
            'table' => Table::class,
            'image' => Image::class,
        ]);
    }
}
