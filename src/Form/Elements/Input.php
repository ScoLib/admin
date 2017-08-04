<?php

namespace Sco\Admin\Form\Elements;

use DB;

class Input extends Element
{
    protected $defaultValue = '';

    protected $maxLength;
    protected $minLength = 0;

    public function getMaxLength()
    {
        if ($this->maxLength) {
            return $this->maxLength;
        }

        return $this->getModelFieldLength();
    }

    protected function getModelFieldLength()
    {
        return $this->getModelColumn()->getLength();
    }

    protected function getModelColumn()
    {
        $table = DB::getTablePrefix() . $this->getModel()->getTable();
        $column = $this->getName();
        return DB::getDoctrineColumn($table, $column);
    }

    public function setMaxLength($value)
    {
        $this->maxLength = intval($value);

        return $this;
    }

    public function getMinLength()
    {
        return $this->minLength;
    }

    public function setMinLength($value)
    {
        $this->minLength = intval($value);

        return $this;
    }

    public function toArray()
    {
        $data = [];
            $data['minlength'] = $this->getMinLength();

            $data['maxlength'] = $this->getMaxLength();

        return parent::toArray() + $data;
    }
}
