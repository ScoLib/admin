<?php


namespace Sco\Admin\View\Columns;

use Sco\Admin\Contracts\ColumnFactoryInterface;
use Sco\Admin\Traits\AliasBinder;

/**
 * @method static \Sco\Admin\View\Columns\Text text($name, $label)
 * @method static \Sco\Admin\View\Columns\DateTime datetime($name, $label)
 * @method static \Sco\Admin\View\Columns\Image image($name, $label)
 * @method static \Sco\Admin\View\Columns\Link link($name, $label)
 * @method static \Sco\Admin\View\Columns\Custom custom($name, $label)
 * @method static \Sco\Admin\View\Columns\Lists lists($name, $label)
 */
class ColumnFactory implements ColumnFactoryInterface
{
    use AliasBinder;

    public function __construct()
    {
        $this->registerAliases([
            'text'     => Text::class,
            'datetime' => DateTime::class,
            'image'    => Image::class,
            'link'     => Link::class,
            'lists'    => Lists::class,
            'custom'   => Custom::class,
        ]);
    }
}
