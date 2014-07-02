<?php

namespace Params;

use Params\Parameters;
use ArrayAccess;
use InvalidArgumentException;

/**
 * Trait that contains a ImmutableParameters instance to use for nestable
 * configuration parameters.
 */
trait ImmutableConfigTrait
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
}
