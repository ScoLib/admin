<?php


namespace Sco\Admin\Form\Elements;

class Text extends Input
{
    protected $type = 'text';

    protected $size = '';

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($value)
    {
        $this->size = $value;

        return $this;
    }

    public function toArray()
    {
        return parent::toArray() + [
                'size' => $this->getSize(),
            ];
    }
}
