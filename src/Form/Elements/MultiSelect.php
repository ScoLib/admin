<?php

namespace Sco\Admin\Form\Elements;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Sco\Admin\Traits\HasSelectOptions;

/**
 * Class MultiSelect
 *
 * @package Sco\Admin\Form\Elements
 * @see http://element.eleme.io/#/en-US/component/select
 */
class MultiSelect extends NamedElement
{
    use HasSelectOptions;

    protected $type = 'select';

    protected $cast = 'json';

    protected $defaultValue = [];

    /**
     *
     * @param string $name
     * @param string $title
     * @param array|Model $options
     */
    public function __construct(string $name, string $title, $options = null)
    {
        parent::__construct($name, $title);

        if (! is_null($options)) {
            $this->setOptions($options);
        }
    }

    public function getValue()
    {
        $value = parent::getValue();

        if ($this->isOptionsModel() && $this->isRelation()) {
            $model = $this->getOptionsModel();
            $key = $this->getOptionsValueAttribute() ?: $model->getKeyName();

            return collect($value)->pluck($key)->map(function ($item) {
                return (string) $item;
            });
        }

        return (array) $value;
    }

    public function save()
    {
        if (! ($this->isOptionsModel() && $this->isRelation())) {
            return parent::save();
        }
    }

    public function finishSave()
    {
        if (! ($this->isOptionsModel() && $this->isRelation())) {
            return;
        }
        $attribute = $this->getName();
        $values = $this->getValueFromRequest();

        $relation = $this->getModel()->{$attribute}();
        if ($relation instanceof BelongsToMany) {
            $relation->sync($values);
        }
    }

    protected function isRelation()
    {
        return method_exists($this->getModel(), $this->getName());
    }

    public function toArray()
    {
        return parent::toArray() + [
                'options'  => $this->getOptions(),
                'multiple' => true,
            ];
    }
}
