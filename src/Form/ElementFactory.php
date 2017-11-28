<?php

namespace Sco\Admin\Form;

use Illuminate\Foundation\Application;
use Sco\Admin\Contracts\Form\ElementFactoryInterface;
use Sco\Admin\Form\Elements\Cascader;
use Sco\Admin\Form\Elements\Checkbox;
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
use Sco\Admin\Form\Elements\MultiSelect;
use Sco\Admin\Form\Elements\Number;
use Sco\Admin\Form\Elements\Password;
use Sco\Admin\Form\Elements\Radio;
use Sco\Admin\Form\Elements\Select;
use Sco\Admin\Form\Elements\Text;
use Sco\Admin\Form\Elements\Textarea;
use Sco\Admin\Form\Elements\Time;
use Sco\Admin\Form\Elements\Timestamp;
use Sco\Admin\Form\Elements\Tree;
use Sco\Admin\Traits\AliasBinder;

/**
 * @method \Sco\Admin\Form\Elements\Text text($name, $title)
 * @method \Sco\Admin\Form\Elements\Email email($name, $title)
 * @method \Sco\Admin\Form\Elements\Select select($name, $title, $options)
 * @method \Sco\Admin\Form\Elements\MultiSelect multiselect($name, $title, $options)
 * @method \Sco\Admin\Form\Elements\Tree tree($name, $title, $nodes)
 * @method \Sco\Admin\Form\Elements\Radio radio($name, $title, $options)
 * @method \Sco\Admin\Form\Elements\Checkbox checkbox($name, $title, $options)
 * @method \Sco\Admin\Form\Elements\Textarea textarea($name, $title)
 * @method \Sco\Admin\Form\Elements\Number number($name, $title)
 * @method \Sco\Admin\Form\Elements\Password password($name, $title)
 * @method \Sco\Admin\Form\Elements\File file($name, $title)
 * @method \Sco\Admin\Form\Elements\Image image($name, $title)
 * @method \Sco\Admin\Form\Elements\Images images($name, $title)
 * @method \Sco\Admin\Form\Elements\Hidden hidden($name)
 * @method \Sco\Admin\Form\Elements\ElSwitch elswitch($name, $title)
 * @method \Sco\Admin\Form\Elements\Time time($name, $title)
 * @method \Sco\Admin\Form\Elements\Date date($name, $title)
 * @method \Sco\Admin\Form\Elements\DateTime datetime($name, $title)
 * @method \Sco\Admin\Form\Elements\Timestamp timestamp($name, $title)
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
            'radio'         => Radio::class,
            'checkbox'      => Checkbox::class,
            'textarea'      => Textarea::class,
            'select'        => Select::class,
            'multiselect'   => MultiSelect::class,
            'hidden'        => Hidden::class,
            'number'        => Number::class,
            'password'      => Password::class,
            'email'         => Email::class,
            'file'          => File::class,
            'image'         => Image::class,
            'images'        => Images::class,
            'elswitch'      => ElSwitch::class,
            'time'          => Time::class,
            'date'          => Date::class,
            'datetime'      => DateTime::class,
            'timestamp'     => Timestamp::class,
            'daterange'     => DateRange::class,
            'datetimerange' => DateTimeRange::class,
            'cascader'      => Cascader::class,
            'tree'          => Tree::class,
        ]);
    }
}
