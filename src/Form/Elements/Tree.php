<?php

namespace Sco\Admin\Form\Elements;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Sco\Admin\Form\Elements\Concerns\HasOptions;

class Tree extends NamedElement
{
    use HasOptions;

    protected $type = 'tree';

    protected $defaultValue = [];

    public function __construct($name, $title, $options)
    {
        parent::__construct($name, $title);

        $this->setOptions($options);
    }

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

    protected function parseOptions($options)
    {
        return collect($options)->mapWithKeys(function ($value, $key) {
            return [
                $key => [
                    'id' => (string)$key,
                    'label' => $value,
                ],
            ];
        })->values();
    }

    public function toArray()
    {
        return parent::toArray() + [
            'options' => $this->getOptions(),
        ];
    }
}
