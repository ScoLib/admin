<?php

namespace Sco\Admin\Component\Concerns;

use KodiComponents\Navigation\Contracts\BadgeInterface;
use Sco\Admin\Navigation\Badge;
use Sco\Admin\Navigation\Page;

trait HasNavigation
{
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
        $page = new Page($this->getTitle(), $this->getViewUrl());
        $page->setPriority($priority);
        $page->setAccessLogic(function () {
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
    protected function getViewUrl(array $parameters = [])
    {
        array_unshift($parameters, $this->getName());

        return route('admin.model.index', $parameters, false);
    }
}
