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
 * @method static Text text(string $name, string $title)
 * @method static Email email(string $name, string $title)
 * @method static Select select(string $name, string $title, $options = null)
 * @method static MultiSelect multiselect(string $name, string $title, $options = null)
 * @method static Tree tree(string $name, string $title, $nodes = null)
 * @method static Radio radio(string $name, string $title, $options = null)
 * @method static Checkbox checkbox(string $name, string $title, $options = null)
 * @method static Textarea textarea(string $name, string $title)
 * @method static Number number(string $name, string $title)
 * @method static Password password(string $name, string $title)
 * @method static File file(string $name, string $title)
 * @method static Image image(string $name, string $title)
 * @method static Images images(string $name, string $title)
 * @method static Hidden hidden($name)
 * @method static ElSwitch elswitch(string $name, string $title)
 * @method static Time time(string $name, string $title)
 * @method static Date date(string $name, string $title)
 * @method static DateTime datetime(string $name, string $title)
 * @method static Timestamp timestamp(string $name, string $title)
 * @method static DateRange daterange(string|array $name, string $title)
 * @method static DateTimeRange datetimerange(string|array $name, string $title)
 * @method static Cascader cascader(string|array $name, string $title, array|\Illuminate\Database\Eloquent\Model $options = null)
 * @method static Tinymce tinymce(string $name, string $title)
 * @method static Markdown markdown(string $name, string $title)
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
