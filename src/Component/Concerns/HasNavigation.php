<?php

namespace Sco\Admin\Component\Concerns;

use InvalidArgumentException;
use KodiComponents\Navigation\Contracts\BadgeInterface;
use Sco\Admin\Navigation\Badge;
use Sco\Admin\Navigation\Page;

trait HasNavigation
{
    /**
     * The page id name.
     *
     * @var string|null
     */
    protected $pageId;

    /**
     * The page icon class name.
     *
     * @var string|null
     */
    protected $icon;

    /**
     * The page belong to page id name.
     *
     * @var string
     */
    protected $parentPageId;

    /**
     * The page priority.
     *
     * @var int
     */
    protected $priority = 100;

    /**
     * Get the page id
     *
     * @return string|null
     */
    public function getPageId()
    {
        return $this->pageId;
    }

    /**
     * Set the page id
     *
     * @param string $pageId
     *
     * @return $this
     */
    public function setPageId(string $pageId)
    {
        $this->pageId = $pageId;

        return $this;
    }

    /**
     * Get the page icon class name.
     *
     * @return string|null
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set the page icon class name.
     *
     * @param string $icon
     *
     * @return $this
     */
    public function setIcon(string $icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getParentPageId(): string
    {
        return $this->parentPageId;
    }

    /**
     * @param string $parentPageId
     *
     * @return $this
     */
    public function setParentPageId(string $parentPageId)
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
     * Make page
     *
     * @param string|Closure|null $badge
     *
     * @return \Sco\Admin\Navigation\Page
     */
    protected function makePage($badge = null)
    {
        $page = new Page($this);
        $page->setPriority($this->getPriority())
            ->setIcon($this->getIcon())
            ->setId($this->getPageId())
            ->setAccessLogic(function () {
                return $this->isDisplay();
            });

        if ($badge) {
            if (! ($badge instanceof BadgeInterface)) {
                $badge = new Badge($badge);
            }
            $page->addBadge($badge);
        }

        return $page;
    }

    /**
     * Get the model display url.
     *
     * @param array $parameters
     *
     * @return string
     */
    public function getDisplayUrl(array $parameters = [])
    {
        array_unshift($parameters, $this->getName());

        return route('admin.model.index', $parameters, false);
    }
}
