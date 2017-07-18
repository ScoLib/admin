<?php


namespace Sco\Admin\View\Columns;

use Sco\Admin\Contracts\ColumnFactoryInterface;
use Sco\Admin\Traits\AliasBinder;

/**
 * @method static Text text($name, $label)
 */
class ColumnFactory implements ColumnFactoryInterface
{
    use AliasBinder;

    public function __construct()
    {

        $this->registerAliases([
            'text' => Text::class,
        ]);
    }
}
