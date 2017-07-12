<?php

namespace Sco\Admin\Navigation;

class Page extends \KodiComponents\Navigation\Page
{
    protected $model;

    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param $model
     *
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }
}
