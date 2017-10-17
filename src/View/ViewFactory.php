<?php

namespace Sco\Admin\View;

use Sco\Admin\Contracts\View\ViewFactoryInterface;
use Sco\Admin\Traits\AliasBinder;

/**
 * @method static \Sco\Admin\View\Table table()
 * @method static \Sco\Admin\View\Tree tree()
 * @method static \Sco\Admin\View\Image image()
 */
class ViewFactory implements ViewFactoryInterface
{
    use AliasBinder;

    public function __construct()
    {
        $this->registerAliases([
            'table' => Table::class,
            'tree'  => Tree::class,
            'image' => Image::class,
        ]);
    }
}
