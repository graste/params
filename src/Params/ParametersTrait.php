<?php

namespace Params;

use Params\Immutable\ImmutableParametersTrait;
use Params\Parameters;
use ArrayAccess;
use InvalidArgumentException;

/**
 * Trait that contains a Parameters instance to use for nestable configuration
 * parameters.
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
     * @param array $data associative array or ArrayAccess implementing object
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
     * @param mixed $parameters Either array or ArrayAccess implementing object.
     *
     * @throws \InvalidArgumentException on wrong data type given
     */
    public function setParameters($parameters)
    {
        if (is_array($parameters) || $parameters instanceof ArrayAccess) {
            $this->parameters = new Parameters($parameters);
        } else {
            throw new InvalidArgumentException(
                "Invalid argument given. Only the 'array' or 'ArrayAccess' implementing objects are supported."
            );
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
