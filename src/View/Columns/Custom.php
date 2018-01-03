<?php

namespace Sco\Admin\View\Columns;

class Custom extends Column
{
    protected $callback;

    public function __construct($name, $label, \Closure $callback = null)
    {
        parent::__construct($name, $label);
        $this->setCallback($callback);
    }

    /**
     * @return mixed
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @param $callback
     *
     * @return $this
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;

        return $this;
    }

    public function getValue()
    {
        $callback = $this->getCallback();

        if (! is_callable($callback)) {
            throw new \InvalidArgumentException('Invalid custom column callback');
        }

        return call_user_func($callback, $this->getModel());
    }
}
