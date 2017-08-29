<?php

namespace Sco\Admin\Form\Elements;

use DB;
use Doctrine\DBAL\Types\Type;

class Input extends NamedElement
{
    protected $maxLength;
    protected $minLength = 0;

    protected $size = '';

    protected $readonly = false;

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
        // Doctrine\DBAL\Platforms\MySQL57Platform not support "enum" "string"
        $databasePlatform = DB::getDoctrineSchemaManager()->getDatabasePlatform();
        $databasePlatform->registerDoctrineTypeMapping('enum', 'string');

        $table  = DB::getTablePrefix() . $this->getModel()->getTable();
        $column = $this->getName();
        return DB::getDoctrineColumn($table, $column);
    }

    public function getMaxLength()
    {
        if ($this->maxLength) {
            return $this->maxLength;
        }

        return $this->getModelFieldLength();
    }

    public function setMaxLength($value)
    {
        $value           = intval($value);
        $this->maxLength = $value;
        $this->addValidationRule('min:' . $value);
        return $this;
    }

    public function getMinLength()
    {
        return $this->minLength;
    }

    public function setMinLength($value)
    {
        $value           = intval($value);
        $this->minLength = $value;

        $this->addValidationRule('max:' . $value);

        return $this;
    }

    public function isReadonly()
    {
        return $this->readonly;
    }

    public function readonly()
    {
        $this->readonly = true;

        return $this;
    }

    public function toArray()
    {
        return parent::toArray() + [
                'minLength' => $this->getMinLength(),
                'maxLength' => $this->getMaxLength(),
                'size'      => $this->getSize(),
                'readonly'  => $this->isReadonly(),
            ];
    }
}
