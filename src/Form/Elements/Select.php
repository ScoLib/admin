<?php

namespace Sco\Admin\Form\Elements;

use Illuminate\Database\Eloquent\Model;
use Sco\Admin\Traits\HasSelectOptions;

class Select extends NamedElement
{
    use HasSelectOptions;

    protected $type = 'select';

    protected $cast = 'string';


    /**
     *
     * @param string $name
     * @param string $title
     * @param array|Model $options
     */
    public function __construct(string $name, string $title, $options = null)
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
