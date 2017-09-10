<?php

namespace Sco\Admin\View;

use Sco\Admin\Contracts\View\ColumnFactoryInterface;
use Sco\Admin\Traits\AliasBinder;
use Sco\Admin\View\Columns\Custom;
use Sco\Admin\View\Columns\DateTime;
use Sco\Admin\View\Columns\Image;
use Sco\Admin\View\Columns\Link;
use Sco\Admin\View\Columns\Tags;
use Sco\Admin\View\Columns\Text;

/**
 * @method static \Sco\Admin\View\Columns\Text text($name, $label)
 * @method static \Sco\Admin\View\Columns\DateTime datetime($name, $label)
 * @method static \Sco\Admin\View\Columns\Image image($name, $label)
 * @method static \Sco\Admin\View\Columns\Link link($name, $label)
 * @method static \Sco\Admin\View\Columns\Custom custom($name, $label)
 * @method static \Sco\Admin\View\Columns\Tags tags($name, $label)
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
            'tags'     => Tags::class,
            'custom'   => Custom::class,
        ]);
    }
}
