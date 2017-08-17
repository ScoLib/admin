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

    protected $model;

    protected $template = '<span>{{value}}</span>';

    public function __construct($name, $label)
    {
        $this->name  = $name;
        $this->label = $label;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    public function setMinWidth($width)
    {
        $this->minWidth = $width;

        return $this;
    }

    public function isSortable()
    {
        $this->sortable = true;

        return $this;
    }

    public function isCustomSortable()
    {
        $this->sortable = 'custom';
        // TODO
        // register sort route

        return $this;
    }

    public function isFixed()
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

    public function getTemplate()
    {
        return $this->template;
    }

    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    public function toArray()
    {
        return [
            'name'     => $this->getName(),
            'label'    => $this->label,
            'width'    => $this->width,
            'fixed'    => $this->fixed,
            'minWidth' => $this->minWidth,
            'sortable' => $this->sortable,
            'template' => $this->getTemplate(),
        ];
    }

    public function getModelValue()
    {
        return $this->getValueFromObject($this->getModel(), $this->getName());
    }

    protected function getValueFromObject($instance, $name)
    {
        $parts = explode('.', $name);
        $part = array_shift($parts);

        if ($instance instanceof Collection) {
            $instance = $instance->pluck($part);
        } elseif (!is_null($instance)) {
            $instance = $instance->getAttribute($part);
        }

        if (!empty($parts) && !is_null($instance)) {
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
