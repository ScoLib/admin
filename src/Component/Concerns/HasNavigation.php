<?php

namespace Sco\Admin\Component\Concerns;

use InvalidArgumentException;
use KodiComponents\Navigation\Contracts\BadgeInterface;
use Sco\Admin\Navigation\Badge;
use Sco\Admin\Navigation\Page;

trait HasNavigation
{
    /**
     * The page id name
     *
     * @var string
     */
    protected $pageId;

    /**
     * The page icon class name
     *
     * @var string
     */
    protected $icon;

    /**
     * The page belong to page id name
     *
     * @var string
     */
    protected $parentPageId;

    /**
     * The page priority
     *
     * @var int
     */
    protected $priority = 100;

    /**
     * @return mixed
     */
    public function getPageId()
    {
        return $this->pageId;
    }

    /**
     * @param mixed $pageId
     *
     * @return $this
     */
    public function setPageId($pageId)
    {
        $this->pageId = $pageId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     *
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParentPageId()
    {
        return $this->parentPageId;
    }

    /**
     * @param mixed $parentPageId
     *
     * @return $this
     */
    public function setParentPageId($parentPageId)
    {
        $this->parentPageId = $parentPageId;

        return $this;
    }

    public function hasParentPageId()
    {
        return $this->parentPageId !== null;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     *
     * @return $this
     */
    public function setPriority(int $priority)
    {
        $this->priority = $priority;

        return $this;
    }

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
    public function addToNavigation($badge = null)
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

        $page = $this->makePage($badge);

        $nav->addPage($page);

        return $page;
    }

    /**
     * page
     *
     * @param null $badge
     *
     * @return \Sco\Admin\Navigation\Page
     */
    protected function makePage($badge = null)
    {
        $page = new Page($this);
        $page->setPriority($this->getPriority())
            ->setIcon($this->getIcon())
            ->serId($this->getPageId())
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
}
