<?php

namespace Sco\Admin\Traits;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

trait SelectOptionsFromModel
{
    protected $optionsLabelAttribute;

    protected $optionsValueAttribute;

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
                    'The select options class must be instanced of "%s".',
                    Model::class
                )
            );
        }

        return $model;
    }

    /**
     *
     * @return array
     */
    protected function setOptionsFromModel()
    {
        if (is_null(($label = $this->getOptionsLabelAttribute()))) {
            throw new InvalidArgumentException('The select options must set label attribute');
        }

        $model = $this->getOptionsModel();

        // $repository = app(RepositoryInterface::class);
        // $repository->setModel($model);

        // $results = $repository->getQuery()->get();
        /**
         * @var \Illuminate\Support\Collection $results
         */
        $results = $model->get();

        $key = $this->getOptionsValueAttribute() ?: $model->getKeyName();

        return $results->pluck($label, $key);
    }
}
