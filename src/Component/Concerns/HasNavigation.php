<?php

namespace Sco\Admin\Component\Concerns;

use KodiComponents\Navigation\Contracts\BadgeInterface;
use Sco\Admin\Navigation\Badge;
use Sco\Admin\Navigation\Page;

trait HasNavigation
{
    protected $icon;

    /**
     * {@inheritdoc}
     */
    public function getNavigation()
    {
        return $this->app['admin.navigation'];
    }

    /**
     * {@inheritdoc}
     */
    public function addToNavigation($priority = 100, $badge = null)
    {
        $page = $this->makePage($priority, $badge);
        $this->getNavigation()->addPage($page);
        return $page;
    }

    /**
     * page
     *
     * @param int  $priority
     * @param null $badge
     *
     * @return \Sco\Admin\Navigation\Page
     */
    protected function makePage($priority = 100, $badge = null)
    {
        $page = new Page($this);
        $page->setPriority($priority)
            ->setIcon($this->getIcon())
            ->setAccessLogic(function () {
                return $this->isView();
            });

        if ($badge) {
            if (!($badge instanceof BadgeInterface)) {
                $badge = new Badge($badge);
            }
            $page->addBadge($badge);
        }

        return $page;
    }

    /**
     * @param array $parameters
     *
     * @return string
     */
    public function getViewUrl(array $parameters = [])
    {
        array_unshift($parameters, $this->getName());

        return route('admin.model.index', $parameters, false);
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function setIcon($value)
    {
        $this->icon = $value;

        return $this;
    }
}
