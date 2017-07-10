<?php


namespace Sco\Admin\Column;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Sco\Attributes\HasAttributesTrait;
use Sco\Attributes\HasOriginalAndAttributesTrait;

abstract class Column
{
    use HasAttributesTrait;

    protected $defaultsAttributes = [
        'title'    => '',
        'sortable' => false,
        'width'    => 0,
    ];

    protected $name;

    protected $defaults = [];

    protected $configFactory;

    protected $model;

    public function __construct($name, $attributes)
    {
        //$this->configFactory = $factory;
        $this->name = $name;
        $this->setAttribute(array_merge($this->getDefaults(), $attributes));
    }

    protected function getDefaults()
    {
        return array_merge($this->defaultsAttributes, $this->defaults);
    }

    public function getName()
    {
        return $this->name;
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

    public function toArray()
    {
        $column = [
            'key'      => $this->name,
            'title'    => $this->getAttribute('title'),
            'sortable' => $this->getAttribute('sortable'),
            'width'    => $this->getAttribute('width'),
        ];

        $template = $this->getAttribute('template');
        if ($template) {
            $column['template'] = $template;
        }

        return $column;
    }

    protected function isRelationship()
    {
        return $this->hasAttribute('relationship');
    }

    protected function getRelationValue()
    {
        $model = $this->getModel();
        $relation = $model->{$this->getAttribute('relationship')}();
        $fields = $this->getAttribute('fields', $this->name);
        $results = $relation->getResults();
        if (strpos($fields, ',') === false) {
            if ($results instanceof Model) {
                return $results->{$fields};
            }
            if ($results instanceof Collection) {
                return $results->pluck($fields);
            }
            return '';
        }

        $values = collect();
        $fields = is_array($fields) ? $fields : explode(',', $fields);

        if ($results instanceof Model) {
            foreach ($fields as $field) {
                $values->put($field, $results->{$field});
            }
        }

        if ($results instanceof Collection) {
            $values = $results->map(function ($item) use ($fields) {
                $map = collect();
                foreach ($fields as $field) {
                    $map->put($field, $item->{$field});
                }
                return $map;
            });
        }
        return $values;
    }

    public function render()
    {
        if (isset($this->getModel()->{$this->name})) {
            $value = $this->getModel()->{$this->name};
        }

        if ($this->isRelationship()) {
            $value = $this->getRelationValue();
        }

        if ($value instanceof Carbon) {
            if ($this->hasAttribute('format')) {
                if ($this->getAttribute('format') == 'humans') {
                    $value = $value->diffForHumans();
                } else {
                    $value = $value->format($this->getAttribute('format'));
                }
            } else {
                $value = (string) $value;
            }
        }

        return $value;
    }

    public function __toString()
    {
        return $this->toJson();
    }
}
