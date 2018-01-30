<?php

namespace Sco\Admin\Traits;

use InvalidArgumentException;

trait HasSelectOptions
{
    use SelectOptionsFromModel;

    protected $options;

    public function getOptions()
    {
        if ($this->options instanceof \Closure) {
            $options = ($this->options)();
        } elseif ($this->isOptionsModel()) {
            $options = $this->getOptionsFromModel();
        } elseif (is_array($this->options)) {
            $options = $this->options;
        } else {
            throw new InvalidArgumentException(
                sprintf(
                    "The %s element[%s] options must be return array(key=>value)",
                    $this->getType(),
                    $this->getName()
                )
            );
        }

        return collect($options)->mapWithKeys(function ($value, $key) {
            return [
                $key => [
                    'label' => $value,
                    'value' => (string) $key,
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
}
