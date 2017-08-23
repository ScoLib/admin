<?php


namespace Sco\Admin\Form\Elements;

class Email extends Text
{
    protected $type = 'email';

    public function __construct($name, $title)
    {
        parent::__construct($name, $title);

        $this->addValidationRule('email');
    }
}
