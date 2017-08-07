<?php

namespace Sco\Admin\Contracts;

interface Validable
{
    public function getValidationRules();

    public function getValidationMessages();

    public function getValidationTitles();
}
