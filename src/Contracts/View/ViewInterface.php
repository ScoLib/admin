<?php

namespace Sco\Admin\Contracts\View;

use Sco\Admin\Contracts\Initializable;
use Sco\Admin\Contracts\WithModel;

interface ViewInterface extends Initializable, WithModel
{
    /**
     * @return \Sco\Admin\Contracts\RepositoryInterface
     */
    public function getRepository();

    /**
     * @return string[]
     */
    public function getWith();

    /**
     * @param array|string[] ...$relations
     *
     * @return $this
     */
    public function with($relations);

    public function get();
}
