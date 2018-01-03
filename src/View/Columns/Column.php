<?php

namespace Sco\Admin\View\Columns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Sco\Admin\Contracts\View\ColumnInterface;

abstract class Column implements ColumnInterface
{
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

    protected $template;

    public function __construct($name, $label)
    {
        $this->setName($name)->setLabel($label);
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

    public function sortable()
    {
        $this->sortable = true;

        return $this;
    }

    public function customSortable()
    {
        $this->sortable = 'custom';
        // TODO
        // register sort route

        return $this;
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
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     *
     * @return Column
     */
    public function setTemplate(string $template)
    {
        $this->template = $template;

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
            'fixed'    => $this->fixed,
            'minWidth' => $this->getMinWidth(),
            'sortable' => $this->sortable,
            'template' => $this->getTemplate(),
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
