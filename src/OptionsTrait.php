<?php

namespace Params;

use ArrayAccess;
use InvalidArgumentException;
use Params\ConfigurableArrayObject;
use Params\Immutable\ImmutableOptionsTrait;

/**
 * Trait that contains an Options instance to use for nestable configuration options.
 */
trait OptionsTrait
{
    use ImmutableOptionsTrait;

    /**
     * Sets a given value for the specified key.
     *
     * @param mixed $key name of entry
     * @param mixed $value value to set for the given key
     * @param bool $replace whether or not to replace values of existing keys
     *
     * @return Options self instance for fluent API
     *
     * @throws \InvalidArgumentException on empty string or null key given
     */
    public function setOption($key, $value, $replace = true)
    {
        $this->getOptions()->set($key, $value, $replace);

        return $this;
    }

    /**
     * Adds the given data (key/value pairs) to the current data.
     *
     * @param array|ConfigurableArrayObject $data associative array or ConfigurableArrayObject implementing object
     * @param bool $replace whether or not to replace values of existing keys
     *
     * @return Options self instance for fluent API
     *
     * @throws \InvalidArgumentException on wrong data type given
     */
    public function addOptions($data = array(), $replace = true)
    {
        $this->getOptions()->add($data, $replace);

        return $this;
    }

    /**
     * Removes the given key from the internal array.
     *
     * @param mixed $key name of key to remove
     *
     * @return Options self instance for fluent API
     */
    public function removeOption($key)
    {
        $this->getOptions()->remove($key);

        return $this;
    }

    /**
     * Delete all internal data.
     *
     * @return Options self instance for fluent API
     */
    public function clearOptions()
    {
        $this->getOptions()->clear();

        return $this;
    }

    /**
     * Set an object's options.
     *
     * @param array|ConfigurableArrayObject $options Either array or ConfigurableArrayObject implementing object.
     *
     * @throws \InvalidArgumentException on wrong data type given
     */
    public function setOptions($options)
    {
        if ($options instanceof ConfigurableArrayObject) {
            $this->options = new Options((array)$options);
        } elseif (is_array($options)) {
            $this->options = new Options($options);
        } else {
            throw new InvalidArgumentException('Only arrays or ConfigurableArrayObject instances are supported.');
        }

        return $this;
    }

    /**
     * Used internally to ensure that the options property is created.
     */
    protected function ensureOptionsCreated()
    {
        if (null === $this->options) {
            $this->options = new Options();
        }
    }
}
