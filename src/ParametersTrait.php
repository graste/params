<?php

namespace Params;

use ArrayAccess;
use InvalidArgumentException;
use Params\ConfigurableArrayObject;
use Params\Immutable\ImmutableParametersTrait;
use Params\Parameters;

/**
 * Trait that contains a Parameters instance to use for nestable configuration parameters.
 */
trait ParametersTrait
{
    use ImmutableParametersTrait;

    /**
     * Sets a given value for the specified key.
     *
     * @param mixed $key name of entry
     * @param mixed $value value to set for the given key
     * @param bool $replace whether or not to replace values of existing keys
     *
     * @return Parameters self instance for fluent API
     *
     * @throws \InvalidArgumentException on empty string or null key given
     */
    public function setParameter($key, $value, $replace = true)
    {
        $this->getParameters()->set($key, $value, $replace);

        return $this;
    }

    /**
     * Adds the given data (key/value pairs) to the current data.
     *
     * @param array|ConfigurableArrayObject $data associative array or ConfigurableArrayObject implementing object
     * @param bool $replace whether or not to replace values of existing keys
     *
     * @return Parameters self instance for fluent API
     *
     * @throws \InvalidArgumentException on wrong data type given
     */
    public function addParameters($data = array(), $replace = true)
    {
        $this->getParameters()->add($data, $replace);

        return $this;
    }

    /**
     * Removes the given key from the internal array.
     *
     * @param mixed $key name of key to remove
     *
     * @return Parameters self instance for fluent API
     */
    public function removeParameter($key)
    {
        $this->getParameters()->remove($key);

        return $this;
    }

    /**
     * Delete all internal data.
     *
     * @return Parameters self instance for fluent API
     */
    public function clearParameters()
    {
        $this->getParameters()->clear();

        return $this;
    }

    /**
     * Set an object's parameters.
     *
     * @param array|ConfigurableArrayObject $parameters Either array or ConfigurableArrayObject implementing object.
     *
     * @throws \InvalidArgumentException on wrong data type given
     */
    public function setParameters($parameters)
    {
        if ($parameters instanceof ConfigurableArrayObject) {
            $this->parameters = new Parameters((array)$parameters);
        } elseif (is_array($parameters)) {
            $this->parameters = new Parameters($parameters);
        } else {
            throw new InvalidArgumentException('Only arrays or ConfigurableArrayObject instances are supported.');
        }

        return $this;
    }

    /**
     * Used internally to ensure that the parameters property is created.
     */
    protected function ensureParametersCreated()
    {
        if (null === $this->parameters) {
            $this->parameters = new Parameters();
        }
    }
}
