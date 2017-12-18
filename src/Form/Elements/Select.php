<?php

namespace Sco\Admin\Form\Elements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Sco\Admin\Contracts\RepositoryInterface;
use Sco\Admin\Traits\SelectOptionsFromModel;

class Select extends NamedElement
{
    use SelectOptionsFromModel;

    protected $type = 'select';

    protected $size = '';

    protected $options;

    protected $extraOptions;

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

    public function getValue()
    {
        return (string)parent::getValue();
    }

    public function toArray()
    {
        return parent::toArray() + [
                'options' => $this->getOptions(),
                'size'    => $this->getSize(),
            ];
    }
}
