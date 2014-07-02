<?php

namespace Params\Immutable;

use Params\Immutable\ImmutableOptions;
use ArrayAccess;
use InvalidArgumentException;

/**
 * Trait that contains an ImmutableOptions instance to use for nestable
 * configuration options.
 */
trait ImmutableOptionsTrait
{
    /**
     * @var ImmutableOptions
     */
    protected $options;

    /**
     * Returns whether the option exists or not.
     *
     * @param mixed $key key to check
     *
     * @return bool true, if key exists; false otherwise
     */
    public function hasOption($key)
    {
        return $this->getOptions()->has($key);
    }

    /**
     * Returns the value for the given key.
     *
     * @param mixed $key key to get value of
     * @param mixed $default value to return if key doesn't exist
     *
     * @return mixed value for that key or default given
     */
    public function getOption($key, $default = null)
    {
        return $this->getOptions()->get($key, $default);
    }

    /**
     * Allows to search for specific data values via JMESPath expressions.
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
        return $this->getOptions()->getValues($expression);
    }

    /**
     * Returns the data as an associative array.
     *
     * @param bool $recursive whether or not nested arrays should be included as array or object
     *
     * @return array with all data
     */
    public function getOptionsAsArray($recursive = true)
    {
        return $this->getOptions()->toArray();
    }

    /**
     * Return this object's immutable options instance.
     *
     * @return ImmutableOptions instance used internally
     */
    public function getOptions()
    {
        $this->ensureOptionsCreated();

        return $this->options;
    }

    /**
     * Used internally to ensure that the data property is created.
     */
    protected function ensureOptionsCreated()
    {
        if (null === $this->options) {
            $this->options = new ImmutableOptions();
        }
    }
}
