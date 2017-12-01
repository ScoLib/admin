<?php

namespace Sco\Admin\Form;

use Illuminate\Foundation\Application;
use Sco\Admin\Contracts\Form\FormFactoryInterface;
use Sco\Admin\Traits\AliasBinder;

/**
 * @method static Form form(array $elements = [])
 */
class FormFactory implements FormFactoryInterface
{
    use AliasBinder;

    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->registerAliases([
            'form' => Form::class,
        ]);
    }
}
