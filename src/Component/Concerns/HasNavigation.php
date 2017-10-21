<?php

namespace Sco\Admin\Component\Concerns;

use InvalidArgumentException;
use KodiComponents\Navigation\Contracts\BadgeInterface;
use Sco\Admin\Navigation\Badge;
use Sco\Admin\Navigation\Page;

trait HasNavigation
{
    protected $icon;

    protected $parentPageId;

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
        $nav = $this->getNavigation();
        if ($this->hasParentPageId()) {
            $nav = $nav->getPages()->findById($this->getParentPageId());
            if (is_null($nav)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Not Found "%s" navigation',
                        $this->getParentPageId()
                    )
                );
            }

        }

        $page = $this->makePage($priority, $badge);

        $nav->addPage($page);

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

        $page->setIcon($this->getIcon());

        return $page;
    }

    public function hasParentPageId()
    {
        return $this->parentPageId !== null;
    }

    public function getParentPageId()
    {
        return $this->parentPageId;
    }

    public function setParentPageId($value)
    {
        $this->parentPageId = $value;

        return $this;
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
