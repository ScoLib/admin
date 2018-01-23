<?php

namespace Sco\Admin\Contracts\Form\Elements;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;
use Sco\Admin\Contracts\WithModel;

/**
 * Interface ElementInterface
 *
 * @package Sco\Admin\Contracts\Form\Elements
 */
interface ElementInterface extends
    WithModel,
    Arrayable,
    Jsonable,
    JsonSerializable
{
    /**
     * Get Element Value
     *
     * @return mixed
     */
    public function getValue();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setName(string $value);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setTitle(string $value);

    /**
     * @return mixed
     */
    public function save();

    /**
     * @return mixed
     */
    public function finishSave();
}
