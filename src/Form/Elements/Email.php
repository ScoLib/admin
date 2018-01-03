<?php

namespace Sco\Admin\Form\Elements;

class Email extends Text
{
    protected $type = 'email';

    protected function getDefaultValidationRules()
    {
        return parent::getDefaultValidationRules() + [
                'email' => 'email',
            ];
    }
}
