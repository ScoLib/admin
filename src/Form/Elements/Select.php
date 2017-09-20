<?php

namespace Sco\Admin\Form\Elements;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Sco\Admin\Contracts\RepositoryInterface;
use Sco\Admin\Form\Elements\Concerns\HasOptions;

class Select extends NamedElement
{
    use HasOptions;

    protected $type = 'select';

    protected $size = '';

    public function __construct($name, $title, $options)
    {
        parent::__construct($name, $title);

        $this->setOptions($options);
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($value)
    {
        $this->size = $value;

        return $this;
    }

    public function getValue()
    {
        return (string)parent::getValue();
    }

    protected function parseOptions($options)
    {
        return collect($options)->mapWithKeys(function ($value, $key) {
            return [
                $key => [
                    'label' => $value,
                    'value' => (string)$key,
                ],
            ];
        })->values();
    }

    public function toArray()
    {
        return parent::toArray() + [
                'options' => $this->getOptions(),
                'size'    => $this->getSize(),
            ];
    }
}
