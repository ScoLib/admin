<?php

namespace Sco\Admin\Form\Elements;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MultiSelect extends Select
{
    protected $defaultValue = [];

    public function getValue()
    {
        $value = $this->getValueFromModel();
        if (empty($value)) {
            return [];
        }

        if ($this->isOptionsModel() && $this->isRelation()) {
            $model = $this->getOptionsModel();
            $key = $this->getOptionsValueAttribute() ?: $model->getKeyName();

            return $value->pluck($key)->map(function ($item) {
                return (string)$item;
            });
        } elseif (is_string($value)) {
            if (strpos($value, ',') !== false) {
                return explode(',', $value);
            }
            return (array)$value;
        }
    }

    public function save()
    {
        if (!($this->isOptionsModel() && $this->isRelation())) {
            parent::save();
        }
    }

    public function finishSave()
    {
        if (!($this->isOptionsModel() && $this->isRelation())) {
            return;
        }
        $attribute = $this->getName();
        $values = $this->getValueFromRequest();

        $relation = $this->getModel()->{$attribute}();
        if ($relation instanceof BelongsToMany) {
            $relation->sync($values);
        }
    }

    protected function isOptionsModel()
    {
        return is_string($this->options) || $this->options instanceof Model;
    }

    protected function isRelation()
    {
        return method_exists($this->getModel(), $this->getName());
    }

    public function toArray()
    {
        return parent::toArray() + [
                'multiple' => true,
            ];
    }
}
