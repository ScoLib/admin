<?php

namespace Sco\Admin\Display\Filters;

use Sco\Admin\Traits\HasSelectOptions;

class Select extends Filter
{
    use HasSelectOptions;

    protected $type = 'select';

    protected $options;

    protected $defaultValue = '';

    public function __construct($name, $title, $options = null)
    {
        parent::__construct($name, $title);

        if (! is_null($options)) {
            $this->setOptions($options);
        }
    }

    public function toArray()
    {
        return parent::toArray() + [
                'options' => $this->getOptions(),
            ];
    }
}
