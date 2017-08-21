<?php

namespace Sco\Admin\Form\Elements;

use DB;
use Doctrine\DBAL\Types\Type;

class Input extends NamedElement
{
    protected $max;
    protected $min;

    public function getMax()
    {
        if ($this->max) {
            return $this->max;
        }

        return $this->getModelFieldLength();
    }

    protected function getModelFieldLength()
    {
        $column = $this->getModelColumn();
        if ($column->getType()->getName() == Type::STRING) {
            return $column->getLength();
        }
        return;
    }

    protected function getModelColumn()
    {
        $table = DB::getTablePrefix() . $this->getModel()->getTable();
        $column = $this->getName();
        return DB::getDoctrineColumn($table, $column);
    }

    public function setMax($value)
    {
        $this->max = $value;

        return $this;
    }

    public function getMin()
    {
        return $this->min;
    }

    public function setMin($value)
    {
        $this->min = intval($value);

        return $this;
    }

    public function toArray()
    {
        $data = [];
        $data['minLength'] = $this->getMin();
        $data['maxLength'] = $this->getMax();

        return parent::toArray() + $data;
    }
}
