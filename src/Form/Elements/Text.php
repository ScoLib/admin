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

    public function largeSize()
    {
        $this->size = 'large';

        return $this;
    }

    public function miniSize()
    {
        $this->size = 'mini';

        return $this;
    }

    public function toArray()
    {
        return parent::toArray() + [
                'size' => $this->getSize(),
            ];
    }
}
