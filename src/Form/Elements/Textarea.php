<?php

namespace Sco\Admin\Form\Elements;

class Textarea extends NamedElement
{
    protected $type = 'textarea';

    protected $rows = 2;

    protected $autoSize = false;

    public function getRows()
    {
        return $this->rows;
    }

    public function setRows($value)
    {
        $this->rows = $value;

        return $this;
    }

    /**
     * @return bool|array
     */
    public function getAutoSize()
    {
        return $this->autoSize;
    }

    /**
     * @param int $max
     * @param int $min
     *
     * @return $this
     */
    public function setAutoSize($max, $min = 1)
    {
        $this->autoSize = [
            'minRows' => intval($min),
            'maxRows' => intval($max),
        ];

        return $this;
    }

    public function toArray()
    {
        return parent::toArray() + [
                'rows'     => $this->getRows(),
                'autosize' => $this->getAutoSize(),
            ];
    }
}
