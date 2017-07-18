<?php


namespace Sco\Admin\View;

use Sco\Admin\Contracts\ViewFactoryInterface;
use Sco\Admin\Traits\AliasBinder;

/**
 * @method static Table table()
 */
class ViewFactory implements ViewFactoryInterface
{
    use AliasBinder;

    public function __construct()
    {
        $this->registerAliases([
            'table' => Table::class,
        ]);
    }
}
