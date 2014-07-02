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
        return $this->options->get($key, $default);
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
        return $this->options->has($key);
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
        $this->options->set($key, $value, $replace);
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
        return $this->options->remove($key);
    }

    /**
     * Delete all options.
     *
     * @return self instance
     */
    public function clearOptions()
    {
        $this->options->clear();
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
        $this->options->add($data, $replace);
        return $this;
    }

    /**
     * Returns all the first level key names.
     *
     * @return array of option keys
     */
    public function getOptionKeys()
    {
        return $this->options->getKeys();
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
    public function getOptionValues($expression = '*')
    {
        return $this->options->getValues($expression);
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
        return $this->options->toArray($recursive);
    }
}
