<?php

namespace Sco\Admin\View\Filters;

class Select extends Filter
{
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
        return $this->options;
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
