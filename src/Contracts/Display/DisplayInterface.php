<?php

namespace Sco\Admin\Contracts\Display;

use Sco\Admin\Contracts\Display\Extensions\ExtensionInterface;
use Sco\Admin\Contracts\WithModel;

interface DisplayInterface extends WithModel
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

    /**
     * @param string $name
     * @param \Sco\Admin\Contracts\Display\Extensions\ExtensionInterface $extension
     * @return $this
     */
    public function extend($name, ExtensionInterface $extension);

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getQuery();

    public function get();
}
