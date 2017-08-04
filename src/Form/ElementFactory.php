<?php


namespace Sco\Admin\Form;

use Illuminate\Foundation\Application;
use Sco\Admin\Contracts\Form\Elements\ElementFactoryInterface;
use Sco\Admin\Form\Elements\Select;
use Sco\Admin\Form\Elements\Text;
use Sco\Admin\Form\Elements\Textarea;
use Sco\Admin\Traits\AliasBinder;

/**
 * @method Text text($name, $title)
 * @method Select select($name, $title)
 * @method Textarea textarea($name, $title)
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
        ]);
    }
}
