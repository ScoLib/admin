<?php

namespace Sco\Admin\Form\Elements;

class Tinymce extends NamedElement
{
    protected $type = 'tinymce';

    protected $size;

    protected $options;

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     *
     * @return Tinymce
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $options
     *
     * @return Tinymce
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    public function toArray()
    {
        return parent::toArray() + [
                'size'    => $this->getSize(),
                'options' => $this->getOptions(),
            ];
    }
}
