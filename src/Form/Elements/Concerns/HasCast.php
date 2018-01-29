<?php

namespace Sco\Admin\Form\Elements\Concerns;

use Illuminate\Support\Collection;

/**
 * Trait hasCast
 *
 * @package Sco\Admin\Form\Elements\Concerns
 */
trait HasCast
{
    /**
     * @var string
     */
    protected $cast;

    /**
     * @return string
     */
    public function getCast()
    {
        return $this->cast;
    }

    /**
     * @param string $cast
     * @return $this
     */
    public function setCast(string $cast)
    {
        $this->cast = $cast;

        return $this;
    }

    /**
     * @return bool
     */
    protected function isCastable()
    {
        return ! is_null($this->getCast());
    }

    /**
     * Determine whether a value is Date / DateTime castable for inbound manipulation.
     *
     * @return bool
     */
    protected function isDateCastable()
    {
        return in_array($this->getCast(), ['date', 'datetime']);
    }

    /**
     * @return bool
     */
    protected function isJsonCastable()
    {
        return in_array($this->getCast(), ['array', 'json', 'object', 'collection']);
    }

    /**
     * @return bool
     */
    protected function isCommaCastable()
    {
        return $this->getCast() === 'comma';
    }

    /**
     * Cast the given value to JSON.
     *
     * @param mixed $value
     * @return string
     */
    protected function castValueAsJson($value)
    {
        $value = $this->asJson($value);

        if ($value === false) {
            throw new \RuntimeException(
                sprintf(
                    "Unable to encode value [%s] for element [%s] to JSON: %s.",
                    $this->getName(),
                    get_class($this),
                    json_last_error_msg()
                )
            );
        }

        return $value;
    }

    /**
     * Encode the given value as JSON.
     *
     * @param $value
     * @return string
     */
    protected function asJson($value)
    {
        return json_encode($value);
    }

    /**
     * Decode the given JSON back into an array or object.
     *
     * @param string $value
     * @param bool $asObject
     * @return mixed
     */
    protected function fromJson($value, $asObject = false)
    {
        return json_decode($value, ! $asObject);
    }

    /**
     * Cast the given value to string with comma.
     *
     * @param mixed $value
     * @return string
     */
    protected function castValueAsCommaSeparated($value)
    {
        if (! is_array($value)) {
            $value = (array) $value;
        }

        return $this->asCommaSeparated($value);
    }

    /**
     * Join the given value with a comma
     *
     * @param array $value
     * @return string
     */
    protected function asCommaSeparated(array $value)
    {
        return implode(',', $value);
    }

    /**
     * Split the given value by comma
     *
     * @param string $value
     * @return array
     */
    protected function fromCommaSeparated(string $value)
    {
        return explode(',', $value);
    }

    /**
     * Cast a value to a native PHP type.
     *
     * @param $value
     * @return array
     */
    protected function castValue($value)
    {
        if (is_null($value)) {
            return $value;
        }

        switch ($this->getCast()) {
            case 'int':
            case 'integer':
                return (int) $value;
            case 'real':
            case 'float':
            case 'double':
                return (float) $value;
            case 'string':
                return (string) $value;
            case 'bool':
            case 'boolean':
                return (bool) $value;
            case 'object':
                return $this->fromJson($value, true);
            case 'array':
            case 'json':
                return $this->fromJson($value);
            case 'collection':
                return new Collection($this->fromJson($value));
            case 'comma':
                return $this->fromCommaSeparated($value);
            case 'date':
                return $this->asDate($value);
            case 'datetime':
                return $this->asDateTime($value);
            case 'timestamp':
                return $this->asTimestamp($value);
            default:
                return $value;
        }
    }
}
