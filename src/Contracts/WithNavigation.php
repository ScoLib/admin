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
     * @param null $badge
     *
     * @return \KodiComponents\Navigation\Contracts\PageInterface
     */
    public function addToNavigation($badge = null);
}
