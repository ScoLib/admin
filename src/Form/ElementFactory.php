<?php

namespace Sco\Admin\Form;

use Illuminate\Foundation\Application;
use Sco\Admin\Contracts\Form\ElementFactoryInterface;
use Sco\Admin\Form\Elements\Date;
use Sco\Admin\Form\Elements\DateRange;
use Sco\Admin\Form\Elements\DateTime;
use Sco\Admin\Form\Elements\DateTimeRange;
use Sco\Admin\Form\Elements\ElSwitch;
use Sco\Admin\Form\Elements\Email;
use Sco\Admin\Form\Elements\File;
use Sco\Admin\Form\Elements\Hidden;
use Sco\Admin\Form\Elements\Image;
use Sco\Admin\Form\Elements\Images;
use Sco\Admin\Form\Elements\Number;
use Sco\Admin\Form\Elements\Password;
use Sco\Admin\Form\Elements\Select;
use Sco\Admin\Form\Elements\Text;
use Sco\Admin\Form\Elements\Textarea;
use Sco\Admin\Traits\AliasBinder;

/**
 * @method \Sco\Admin\Form\Elements\Text text($name, $title)
 * @method \Sco\Admin\Form\Elements\Text email($name, $title)
 * @method \Sco\Admin\Form\Elements\Select select($name, $title, $options)
 * @method \Sco\Admin\Form\Elements\Textarea textarea($name, $title)
 * @method \Sco\Admin\Form\Elements\Number number($name, $title)
 * @method \Sco\Admin\Form\Elements\Password password($name, $title)
 * @method \Sco\Admin\Form\Elements\File file($name, $title)
 * @method \Sco\Admin\Form\Elements\Image image($name, $title)
 * @method \Sco\Admin\Form\Elements\Images images($name, $title)
 * @method \Sco\Admin\Form\Elements\Hidden hidden($name)
 * @method \Sco\Admin\Form\Elements\ElSwitch elswitch($name, $title)
 * @method \Sco\Admin\Form\Elements\Date date($name, $title)
 * @method \Sco\Admin\Form\Elements\DateTime datetime($name, $title)
 * @method \Sco\Admin\Form\Elements\DateRange daterange($startName, $endName, $title)
 * @method \Sco\Admin\Form\Elements\DateTimeRange datetimerange($startName, $endName, $title)
 */
class ElementFactory implements ElementFactoryInterface
{
    use AliasBinder;

    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->registerAliases([
            'text'          => Text::class,
            'select'        => Select::class,
            'textarea'      => Textarea::class,
            'hidden'        => Hidden::class,
            'number'        => Number::class,
            'password'      => Password::class,
            'email'         => Email::class,
            'file'          => File::class,
            'image'         => Image::class,
            'images'        => Images::class,
            'elswitch'      => ElSwitch::class,
            'date'          => Date::class,
            'datetime'      => DateTime::class,
            'daterange'     => DateRange::class,
            'datetimerange' => DateTimeRange::class,
        ]);
    }
}
