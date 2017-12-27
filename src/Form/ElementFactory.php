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
use Sco\Admin\Form\Elements\Markdown;
use Sco\Admin\Form\Elements\MultiSelect;
use Sco\Admin\Form\Elements\Number;
use Sco\Admin\Form\Elements\Password;
use Sco\Admin\Form\Elements\Radio;
use Sco\Admin\Form\Elements\Select;
use Sco\Admin\Form\Elements\Text;
use Sco\Admin\Form\Elements\Textarea;
use Sco\Admin\Form\Elements\Time;
use Sco\Admin\Form\Elements\Timestamp;
use Sco\Admin\Form\Elements\Tinymce;
use Sco\Admin\Form\Elements\Tree;
use Sco\Admin\Traits\AliasBinder;

/**
 * @method static Text text($name, $title)
 * @method static Email email($name, $title)
 * @method static Select select($name, $title, $options)
 * @method static MultiSelect multiselect($name, $title, $options)
 * @method static Tree tree($name, $title, $nodes)
 * @method static Radio radio($name, $title, $options)
 * @method static Checkbox checkbox($name, $title, $options)
 * @method static Textarea textarea($name, $title)
 * @method static Number number($name, $title)
 * @method static Password password($name, $title)
 * @method static File file($name, $title)
 * @method static Image image($name, $title)
 * @method static Images images($name, $title)
 * @method static Hidden hidden($name)
 * @method static ElSwitch elswitch($name, $title)
 * @method static Time time($name, $title)
 * @method static Date date($name, $title)
 * @method static DateTime datetime($name, $title)
 * @method static Timestamp timestamp($name, $title)
 * @method static DateRange daterange($startName, $endName, $title)
 * @method static DateTimeRange datetimerange($startName, $endName, $title)
 * @method static Tinymce tinymce($name, $title)
 * @method static Markdown markdown($name, $title)
 */
class ElementFactory implements ElementFactoryInterface
{
    use AliasBinder;

    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->register([
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
            'tinymce'       => Tinymce::class,
            'markdown'      => Markdown::class,
        ]);
    }
}
