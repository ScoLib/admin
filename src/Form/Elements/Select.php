<?php

namespace Sco\Admin\Form\Elements;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Sco\Admin\Contracts\RepositoryInterface;

class Select extends NamedElement
{
    protected $type = 'select';

    protected $options = [];

    protected $optionsLabelAttribute;

    protected $optionsValueAttribute;

    protected $size = '';

    public function __construct($name, $title, $options)
    {
        parent::__construct($name, $title);
        $this->setOptions($options);
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($value)
    {
        $this->size = $value;

        return $this;
    }

    public function getValue()
    {
        return (string)parent::getValue();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getOptions()
    {
        if ($this->options instanceof \Closure) {
            $options = ($this->options)();
        } elseif (is_string($this->options) || $this->options instanceof Model) {
            $options = $this->setOptionsFromModel();
        } elseif (is_array($this->options)) {
            $options = $this->options;
        } else {
            throw new InvalidArgumentException(
                sprintf(
                    "The form %s element's options must be return array(key=>value)",
                    $this->getType()
                )
            );
        }

        return collect($options)->mapWithKeys(function ($value, $key) {
            return [
                $key => [
                    'label' => $value,
                    'value' => (string)$key,
                ],
            ];
        })->values();
    }

    /**
     * @param mixed $options
     *
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     *
     * @return array
     */
    protected function setOptionsFromModel()
    {
        $model = $this->getOptionsModel();

        $key = $this->getOptionsValueAttribute() ?: $model->getKeyName();

        $repository = app(RepositoryInterface::class);
        $repository->setModel($model);
        $query = $repository->getQuery();

        $results = $query->get();
        if (is_null(($label = $this->getOptionsLabelAttribute()))) {
            throw new InvalidArgumentException('Form select element must set label attribute');
        }
        return $results->pluck($this->getOptionsLabelAttribute(), $key);
    }

    /**
     * @return Model
     */
    public function getOptionsModel()
    {
        $model = $this->options;

        if (is_string($model)) {
            $model = app($model);
        }

        if (!($model instanceof Model)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Form select element options class must be instanced of "%s".',
                    Model::class
                )
            );
        }

        return $model;
    }

    /**
     * 获取 options 标题字段
     *
     * @return string
     */
    public function getOptionsLabelAttribute()
    {
        return $this->optionsLabelAttribute;
    }

    /**
     * 设置 options 标题字段
     *
     * @param string $value
     *
     * @return $this
     */
    public function setOptionsLabelAttribute($value)
    {
        $this->optionsLabelAttribute = $value;

        return $this;
    }

    /**
     * 获取 options value 字段
     *
     * @return string
     */
    public function getOptionsValueAttribute()
    {
        return $this->optionsValueAttribute;
    }

    /**
     * 设置 options value 字段
     *
     * @param string $value
     *
     * @return $this
     */
    public function setOptionsValueAttribute($value)
    {
        $this->optionsValueAttribute = $value;

        return $this;
    }

    public function toArray()
    {
        return parent::toArray() + [
                'options' => $this->getOptions(),
                'size'    => $this->getSize(),
            ];
    }
}
