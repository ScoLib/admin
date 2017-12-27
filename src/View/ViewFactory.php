<?php

namespace Sco\Admin\View;

use Sco\Admin\Contracts\View\ViewFactoryInterface;
use Sco\Admin\Traits\AliasBinder;

/**
 * @method static Table table()
 * @method static Tree tree()
 * @method static Image image()
 */
class ViewFactory implements ViewFactoryInterface
{
    use AliasBinder;

    public function __construct()
    {
        $this->register([
            'table' => Table::class,
            'tree'  => Tree::class,
            'image' => Image::class,
        ]);
    }
}
