<?php


namespace Sco\Admin\Form;

use Illuminate\Foundation\Application;
use Sco\Admin\Contracts\Form\Elements\ElementFactoryInterface;
use Sco\Admin\Form\Elements\Hidden;
use Sco\Admin\Form\Elements\Number;
use Sco\Admin\Form\Elements\Select;
use Sco\Admin\Form\Elements\Text;
use Sco\Admin\Form\Elements\Textarea;
use Sco\Admin\Traits\AliasBinder;

/**
 * @method Text text($name, $title)
 * @method Select select($name, $title)
 * @method Textarea textarea($name, $title)
 * @method Number number($name, $title)
 * @method Hidden hidden($name)
 */
class ElementFactory implements ElementFactoryInterface
{
    use AliasBinder;

    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->registerAliases([
            'text'     => Text::class,
            'select'   => Select::class,
            'textarea' => Textarea::class,
            'hidden'   => Hidden::class,
            'number'   => Number::class,
        ]);
    }
}
