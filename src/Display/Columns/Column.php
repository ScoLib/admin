<?php

namespace Sco\Admin\Display\Columns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Sco\Admin\Contracts\Display\ColumnInterface;

abstract class Column implements ColumnInterface
{
    protected $type;

    protected $name;

    protected $label;

    protected $width = 0;

    protected $minWidth = 80;

    protected $sortable = false;

    protected $fixed = false;

    /**
     * @var Model
     */
    protected $model;

    protected $defaultValue = '';

    public function __construct($name, $label)
    {
        $this->setName($name)->setLabel($label);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Column
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     *
     * @return Column
     */
    public function setLabel(string $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     *
     * @return Column
     */
    public function setWidth(int $width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return int
     */
    public function getMinWidth()
    {
        return $this->minWidth;
    }

    /**
     * @param int $minWidth
     *
     * @return Column
     */
    public function setMinWidth(int $minWidth)
    {
        $this->minWidth = $minWidth;

        return $this;
    }

    public function getSortable()
    {
        return $this->sortable;
    }

    /**
     * @return $this
     */
    public function enableSortable()
    {
        $this->sortable = true;

        return $this;
    }

    /**
     *
     * @return $this
     */
    public function customSortable()
    {
        $this->sortable = 'custom';

        return $this;
    }

    public function isFixed()
    {
        return $this->fixed;
    }

    public function enableFixed()
    {
        $this->fixed = true;

        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * The column options
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'name'     => $this->getName(),
            'label'    => $this->getLabel(),
            'width'    => $this->getWidth(),
            'fixed'    => $this->isFixed(),
            'minWidth' => $this->getMinWidth(),
            'sortable' => $this->getSortable(),
            'type'     => $this->getType(),
        ];
    }

    /**
     * Set the column default value
     *
     * @param mixed $value
     *
     * @return $this
     */
    public function setDefaultValue($value)
    {
        $this->defaultValue = $value;

        return $this;
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * Get the column value
     *
     * @return string|static
     */
    public function getValue()
    {
        $value = $this->getModelValue();
        if (is_null($value)) {
            $value = $this->getDefaultValue();
        }

        return $value;
    }

    protected function getModelValue()
    {
        return $this->getValueFromObject($this->getModel(), $this->getName());
    }

    protected function getValueFromObject($instance, $name)
    {
        $parts = explode('.', $name);
        $part = array_shift($parts);

        if ($instance instanceof Collection) {
            $instance = $instance->pluck($part);
        } elseif (! is_null($instance)) {
            $instance = $instance->getAttribute($part);
        }

        if (! empty($parts) && ! is_null($instance)) {
            return $this->getValueFromObject($instance, implode('.', $parts));
        }

        return $instance;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    public function __toString()
    {
        return $this->toJson();
    }
}
