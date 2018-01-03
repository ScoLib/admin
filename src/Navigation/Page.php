<?php

namespace Sco\Admin\Navigation;

class Page extends \KodiComponents\Navigation\Page
{
    /**
     * @var null|\Sco\Admin\Contracts\ComponentInterface
     */
    protected $component;

    public function __construct($component = null)
    {
        parent::__construct();

        $this->component = $component;
    }

    public function getComponent()
    {
        return $this->component;
    }

    public function hasComponent()
    {
        return ! is_null($this->getComponent());
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    public function getTitle()
    {
        if ($this->hasComponent()) {
            return $this->getComponent()->getTitle();
        }

        return parent::getTitle();
    }

    public function getUrl()
    {
        if ($this->hasComponent()) {
            return $this->getComponent()->getViewUrl();
        }

        return $this->url;
    }
}
