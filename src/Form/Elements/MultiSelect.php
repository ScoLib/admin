<?php

namespace Sco\Admin\Form\Elements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;

class MultiSelect extends Select
{
    protected $defaultValue = [];

    public function getValue()
    {
        $value = $this->getValueFromModel();
        if (empty($value)) {
            return $value;
        }

        if ($this->isOptionsModel() && $this->isRelation()) {
            $model = $this->getOptionsModel();
            $key = $this->getOptionsValueAttribute() ?: $model->getKeyName();

            $value = $value->pluck($key)->map(function ($item) {
                return (string)$item;
            });
        }
        return $value;
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

    public function toArray()
    {
        return parent::toArray() + [
                'multiple' => true,
            ];
    }
}
