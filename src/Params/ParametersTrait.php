<?php

namespace Params;

use Params\Parameters;
use ArrayAccess;
use InvalidArgumentException;

/**
 * Trait that contains a Parameters instance to use for nestable configuration
 * parameters.
 */
trait ParametersTrait
{
    protected $parameters;

    /**
     * Returns the parameter value for the given parameter key.
     *
     * @param string $key key of parameter
     * @param mixed $default value to return if parameter doesn't exist
     *
     * @return mixed value for that parameter or default given
     */
    public function getParameter($key, $default = null)
    {
        return $this->getParameters()->get($key, $default);
    }

    /**
     * Returns whether the parameter exists or not.
     *
     * @param string $key key to check
     *
     * @return bool true, if parameter exists; false otherwise
     */
    public function hasParameter($key)
    {
        return $this->getParameters()->has($key);
    }

    /**
     * Sets a given value for the specified parameter.
     *
     * @param string $key key of the parameter
     * @param mixed $value value to set for the given parameter key
     * @param bool $replace whether or not to replace values of existing keys
     *
     * @return self instance
     */
    public function setParameter($key, $value, $replace = true)
    {
        $this->getParameters()->set($key, $value, $replace);
        return $this;
    }

    /**
     * Removes the given parameter.
     *
     * @param string $key name of key to remove
     *
     * @return mixed|null value of the removed key
     */
    public function removeParameter($key)
    {
        return $this->getParameters()->remove($key);
    }

    /**
     * Delete all parameters.
     *
     * @return self instance
     */
    public function clearParameters()
    {
        $this->getParameters()->clear();
        return $this;
    }

    /**
     * Adds the given parameters to the current ones.
     *
     * @param array $data array of key-value pairs or ArrayAccess implementing object
     * @param bool $replace whether or not to replace values of existing keys
     *
     * @return self instance for fluent API
     *
     * @throws InvalidArgumentException on invalid data type given
     */
    public function addParameters($data = array(), $replace = true)
    {
        $this->getParameters()->add($data, $replace);
        return $this;
    }

    /**
     * Returns all the first level key names.
     *
     * @return array of parameter keys
     */
    public function getParameterKeys()
    {
        return array_keys((array)$this->getParameters());
    }

    /**
     * Allows to search for specific parameters via JMESPath expressions.
     *
     * Some example expressions as a quick start:
     *
     * - "nested.key"           returns the value of the nested "key"
     * - "nested.*"             returns all values available under the "nested" key
     * - "*.key"                returns all values of "key"s on any second level array
     * - "[key, nested.key]"    returns first level "key" value and the first value of the "nested" key array
     * - "[key, nested[0]"      returns first level "key" value and the first value of the "nested" key array
     * - "nested.key || key"    returns the value of the first matching expression
     *
     * @see http://jmespath.readthedocs.org/en/latest/ and https://github.com/mtdowling/jmespath.php
     *
     * @param string $expression JMESPath expression to evaluate on stored data
     *
     * @return mixed|null data in various types (scalar, array etc.) depending on the found results
     *
     * @throws \JmesPath\SyntaxErrorException on invalid expression syntax
     * @throws \RuntimeException e.g. if JMESPath cache directory cannot be written
     * @throws \InvalidArgumentException e.g. if JMESPath builtin functions can't be called
     */
    public function searchParameters($expression = '*')
    {
        return $this->getParameters()->search($expression);
    }

    /**
     * Returns the parameters data as an associative array.
     *
     * @param bool $recursive whether or not nested arrays should be included as array or object
     *
     * @return array with all data
     */
    public function getParametersAsArray($recursive = true)
    {
        $data = array();

        foreach ($this->getParameters() as $key => $value) {
            if (is_object($value) && $recursive && is_callable(array($value, 'toArray'))) {
                $data[$key] = $value->toArray();
            } else {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * Return this object's parameters instance.
     *
     * @return Parameters instance used internally
     */
    public function getParameters()
    {
        $this->ensureParametersCreated();
        return $this->parameters;
    }

    /**
     * Set an object's parameters.
     *
     * @param mixed $parameters Either array or ArrayAccess implementing object.
     */
    public function setParameters($parameters)
    {
        if ($parameters instanceof Parameters) {
            $this->parameters = $parameters;
        } elseif (is_array($parameters) || $parameters instanceof ArrayAccess) {
            $this->parameters = new Parameters($parameters);
        } else {
            throw new InvalidArgumentException(
                "Invalid argument given. Only the types 'Params\Parameters' and 'array' are supported."
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
