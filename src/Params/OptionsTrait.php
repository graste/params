<?php

namespace Params;

use Params\Parameters;
use ArrayAccess;
use InvalidArgumentException;

/**
 * Trait that contains a Parameters instance to use for nestable configuration
 * options.
 */
trait OptionsTrait
{
    protected $options;

    /**
     * Returns the option value for the given option key.
     *
     * @param string $key key of option
     * @param mixed $default value to return if option doesn't exist
     *
     * @return mixed value for that option or default given
     */
    public function getOption($key, $default = null)
    {
        return $this->getOptions()->get($key, $default);
    }

    /**
     * Returns whether the option exists or not.
     *
     * @param string $key key of the option to check
     *
     * @return bool true, if option exists; false otherwise
     */
    public function hasOption($key)
    {
        return $this->getOptions()->has($key);
    }

    /**
     * Sets a given value for the specified option.
     *
     * @param string $key key of the option
     * @param mixed $value value to set for the given option name
     * @param bool $replace whether or not to replace values of existing keys
     *
     * @return self instance
     */
    public function setOption($key, $value, $replace = true)
    {
        $this->getOptions()->set($key, $value, $replace);
        return $this;
    }

    /**
     * Removes the given option.
     *
     * @param string $key name of key to remove
     *
     * @return mixed|null value of the removed key
     */
    public function removeOption($key)
    {
        return $this->getOptions()->remove($key);
    }

    /**
     * Delete all options.
     *
     * @return self instance
     */
    public function clearOptions()
    {
        $this->getOptions()->clear();
        return $this;
    }

    /**
     * Adds the given options to the current ones.
     *
     * @param array $data array of key-value pairs or ArrayAccess implementing object
     * @param bool $replace whether or not to replace values of existing keys
     *
     * @return self instance for fluent API
     *
     * @throws InvalidArgumentException on invalid data type given
     */
    public function addOptions($data = array(), $replace = true)
    {
        $this->getOptions()->add($data, $replace);
        return $this;
    }

    /**
     * Returns all the first level key names.
     *
     * @return array of option keys
     */
    public function getOptionKeys()
    {
        return array_keys((array)$this->getOptions());
    }

    /**
     * Allows to search for specific options via JMESPath expressions.
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
    public function searchOptions($expression = '*')
    {
        return $this->getOptions()->search($expression);
    }

    /**
     * Returns the options data as an associative array.
     *
     * @param bool $recursive whether or not nested arrays should be included as array or object
     *
     * @return array with all data
     */
    public function getOptionsAsArray($recursive = true)
    {
        $data = array();

        foreach ($this->getOptions() as $key => $value) {
            if (is_object($value) && $recursive && is_callable(array($value, 'toArray'))) {
                $data[$key] = $value->toArray();
            } else {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * Return this object's options instance.
     *
     * @return Parameters instance used internally
     */
    public function getOptions()
    {
        $this->ensureOptionsCreated();
        return $this->options;
    }

    /**
     * Set an object's options.
     *
     * @param mixed $options array or ArrayAccess implementing instance
     *
     * @return self instance
     */
    public function setOptions($options)
    {
        if ($options instanceof Parameters) {
            $this->options = $options;
        } elseif (is_array($options) || $options instanceof ArrayAccess) {
            $this->options = new Parameters($options);
        } else {
            throw new InvalidArgumentException(
                "Invalid argument given. Only the types 'Params\Parameters' and 'array' are supported."
            );
        }

        return $this;
    }

    /**
     * Used internally to ensure that the options property is created.
     */
    protected function ensureOptionsCreated()
    {
        if (null === $this->options) {
            $this->options = new Parameters();
        }
    }
}
