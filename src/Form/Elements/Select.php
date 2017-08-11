<?php


namespace Sco\Admin\Form\Elements;

use Illuminate\Database\Eloquent\Model;
use Sco\Admin\Contracts\RepositoryInterface;
use Sco\Admin\Exceptions\InvalidArgumentException;

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

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getOptions()
    {
        if ($this->options instanceof \Closure) {
            $options = $this->options();
        } elseif (is_string($this->options) || $this->options instanceof Model) {
            $options = $this->setOptionsFromModel($this->options);
        }

        if (!is_array($options)) {
            throw new InvalidArgumentException('Form select element options must be array(key=>value)');
        }

        return collect($options)->mapWithKeys(function ($value, $key) {
            return [
                $key => [
                    'label' => $value,
                    'value' => $key,
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
     * @param Model|string $options
     *
     * @return array
     */
    protected function setOptionsFromModel($options)
    {
        if (is_string($options)) {
            $options = app($options);
        }

        if (!($options instanceof Model)) {
            throw new InvalidArgumentException('Form select element options class must be instanced of Illuminate\Database\Eloquent\Model');
        }

        $key = $this->getOptionsValueAttribute() ?: $options->getKeyName();

        $repository = app(RepositoryInterface::class);
        $repository->setModel($options);
        $query = $repository->getQuery();

        $options = $query->get();
        if (is_null(($label = $this->getOptionsLabelAttribute()))) {
            throw new InvalidArgumentException('Form select element must set label attribute');
        }

        return array_pluck($options->all(), $this->getOptionsLabelAttribute(), $key);
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