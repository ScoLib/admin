<?php

namespace Sco\Admin\Contracts;

interface WithNavigation
{
    /**
     * @return \KodiComponents\Navigation\Contracts\NavigationInterface
     */
    public function getNavigation();

    /**
     * add Navigation
     *
     * @param int  $priority
     * @param null $badge
     *
     * @return \KodiComponents\Navigation\Contracts\PageInterface
     */
    public function addToNavigation($priority = 100, $badge = null);
}
