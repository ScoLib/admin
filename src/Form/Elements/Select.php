<?php

namespace Sco\Admin\Form\Elements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Sco\Admin\Contracts\RepositoryInterface;

class Select extends NamedElement
{
    protected $type = 'select';

    protected $size = '';

    protected $options;

    protected $extraOptions;

    protected $optionsLabelAttribute;

    protected $optionsValueAttribute;

    public function __construct($name, $title, $options = null)
    {
        parent::__construct($name, $title);

        $this->setOptions($options);

        $this->extraOptions = new Collection();
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

    public function addOptions($options)
    {
        foreach ($options as $key => $option) {
            $this->addOption($key, $option);
        }

        return $this;
    }

    public function addOption($key, $value)
    {
        $this->extraOptions->put($key, $value);

        return $this;
    }

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
                "The form select element's options must be return array(key=>value)"
            );
        }

        $this->extraOptions->each(function ($value, $key) use ($options) {
            $options[$key] = $value;
        });

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
        if (is_null(($label = $this->getOptionsLabelAttribute()))) {
            throw new InvalidArgumentException(
                sprintf(
                    'Form %s element must set label attribute',
                    $this->getType()
                )
            );
        }

        $model = $this->getOptionsModel();

        $repository = app(RepositoryInterface::class);
        $repository->setModel($model);

        $results = $repository->getQuery()->get();

        $key = $this->getOptionsValueAttribute() ?: $model->getKeyName();

        return $results->pluck($label, $key);
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
                    'Form %s element options class must be instanced of "%s".',
                    $this->getType(),
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
