<?php

namespace Sco\Admin\View\Columns;

class Mapping extends Column
{
    protected $mappings = [
        '0' => 'No',
        '1' => 'Yes',
    ];

    public function __construct($name, $label, $mappings = null)
    {
        parent::__construct($name, $label);

        if ($mappings) {
            $this->setMappings($mappings);
        }
    }

    /**
     * @return array
     */
    public function getMappings()
    {
        return $this->mappings;
    }

    /**
     * @param array|\Closure $mappings
     *
     * @return $this
     */
    public function setMappings($mappings)
    {
        if ($mappings instanceof \Closure) {
            $mappings = $mappings();
        }

        $this->mappings = (array)$mappings;

        return $this;
    }

    public function getValue()
    {
        $value = parent::getValue();
        return $this->mappings[$value] ?? $value;
    }
}
