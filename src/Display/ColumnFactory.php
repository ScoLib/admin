<?php

namespace Sco\Admin\Display;

use Sco\Admin\Contracts\Display\ColumnFactoryInterface;
use Sco\Admin\Traits\AliasBinder;
use Sco\Admin\Display\Columns\Custom;
use Sco\Admin\Display\Columns\DateTime;
use Sco\Admin\Display\Columns\Html;
use Sco\Admin\Display\Columns\Image;
use Sco\Admin\Display\Columns\Link;
use Sco\Admin\Display\Columns\Mapping;
use Sco\Admin\Display\Columns\Tags;
use Sco\Admin\Display\Columns\Text;

/**
 * @method static Text text($name, $label) text type column
 * @method static DateTime datetime($name, $label) datetime type column
 * @method static Image image($name, $label) image type column
 * @method static Link link($name, $label) link type column
 * @method static Custom custom($name, $label, \Closure $callback = null) custom type
 *         column
 * @method static Tags tags($name, $label) tags type column
 * @method static Html html($name, $label) tags type column
 * @method static Mapping mapping($name, $label, $mappings = null) mapping type column
 */
class ColumnFactory implements ColumnFactoryInterface
{
    use AliasBinder;

    public function __construct()
    {
        $this->register([
            'text'     => Text::class,
            'datetime' => DateTime::class,
            'image'    => Image::class,
            'link'     => Link::class,
            'tags'     => Tags::class,
            'custom'   => Custom::class,
            'mapping'  => Mapping::class,
            'html'     => Html::class,
        ]);
    }
}
