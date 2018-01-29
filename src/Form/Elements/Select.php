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

    protected $cast = 'string';

    protected $options;

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

    public function toArray()
    {
        return parent::toArray() + [
                'options' => $this->getOptions(),
            ];
    }
}
