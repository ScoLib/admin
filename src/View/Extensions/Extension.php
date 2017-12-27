<?php

namespace Sco\Admin\View\Extensions;

use Illuminate\Support\Collection;
use Sco\Admin\Contracts\View\Extensions\ExtensionInterface;

abstract class Extension extends Collection implements ExtensionInterface
{

    abstract public function add($value);

    /**
     * Wipe item.
     *
     * @return $this
     */
    public function clear()
    {
        $this->items = [];

        return $this;
    }

    /**
     * @param $values
     *
     * @return $this
     */
    public function set($values)
    {
        $this->clear();

        if (!is_array($values)) {
            $values = func_get_args();
        }

        foreach ($values as $value) {
            $this->add($value);
        }

        return $this;
    }
}
