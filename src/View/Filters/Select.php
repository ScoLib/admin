<?php

namespace Sco\Admin\View\Filters;

use Illuminate\Database\Eloquent\Model;
use Sco\Admin\Traits\SelectOptionsFromModel;

class Select extends Filter
{
    use SelectOptionsFromModel;

    protected $type = 'select';

    protected $options;

    protected $defaultValue = '';

    public function __construct($name, $title, $options = null)
    {
        parent::__construct($name, $title);

        $this->setOptions($options);
    }

    /**
     * @return mixed
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
                "The select options must be return array(key=>value)"
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
     * @return Select
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    public function toArray()
    {
        return parent::toArray() + [
                'options' => $this->getOptions(),
            ];
    }
}
