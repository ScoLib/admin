<?php

namespace Sco\Admin\Contracts\Display;

use Sco\Admin\Contracts\Initializable;
use Sco\Admin\Contracts\WithModel;

interface DisplayInterface extends Initializable, WithModel
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
