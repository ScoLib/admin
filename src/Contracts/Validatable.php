<?php

namespace Sco\Admin\Contracts;

interface Validatable
{
    public function getValidationRules();

    public function getValidationMessages();

    public function getValidationTitles();
}
