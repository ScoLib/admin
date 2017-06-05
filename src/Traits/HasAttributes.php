<?php


namespace Sco\Admin\Traits;

use Illuminate\Support\Arr;

trait HasAttributes
{
    protected $attributes = [];

    /**
     * Set a given log value.
     *
     * @param array|string $key
     * @param mixed        $value
     */
    public function setAttribute($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            Arr::set($this->attributes, $key, $value);
        }
    }

    /**
     * Get the specified log value.
     *
     * @param null|string $key
     * @param mixed       $default
     *
     * @return mixed
     */
    public function getAttribute($key = null, $default = null)
    {
        return Arr::get($this->attributes, $key, $default);
    }


    public function merge(array $attributes)
    {
        $this->attributes = array_merge($this->attributes, $attributes);

        return $this;
    }
}
