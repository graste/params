<?php

namespace Params;

use JmesPath\Env as JmesPath;
use InvalidArgumentException;
use ArrayAccess;

/**
 * Class that wraps an associative array for
 * more convenient access of keys and values.
 */
class Parameters implements ArrayAccess
{
    /**
     * @var array
     */
    protected $parameters = array();

    /**
     * Create a new instance with the given parameters as
     * initial value set.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = array())
    {
        $this->parameters = $parameters;
    }

    /**
     * Returns the value for the given key.
     *
     * @param string $key name of key
     * @param mixed $default value to return if key doesn't exist
     *
     * @return mixed value for that key or default given
     */
    public function get($key, $default = null)
    {
        if (isset($this->parameters[$key]) || array_key_exists($key, $this->parameters)) {
            return $this->parameters[$key];
        }

        return $default;
    }

    /**
     * Sets a given value for the specified key.
     *
     * @param string $key name of entry
     * @param mixed $value value to set for the given key
     *
     * @return Parameters self instance for fluent API
     */
    public function set($key, $value)
    {
        if (empty($key)) {
            throw new InvalidArgumentException('Invalid key given.');
        }

        $this->parameters[$key] = $value;

        return $this;
    }

    /**
     * Returns whether the key exists or not.
     *
     * @param string $key name of key to check
     *
     * @return bool true, if key exists; false otherwise
     */
    public function has($key)
    {
        if (isset($this->parameters[$key]) || array_key_exists($key, $this->parameters)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $key name of key
     * @param mixed $value value to set for key
     */
    public function offsetSet($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    /**
     * @param string $key name of key
     *
     * @return mixed value of that key
     *
     * @throws \InvalidArgumentException if key does not exist
     */
    public function offsetGet($key)
    {
        if (!$this->has($key)) {
            throw new InvalidArgumentException(sprintf('Key "%s" is not defined.', $key));
        }

        return $this->get($key);
    }

    /**
     * Returns whether the key exists or not.
     *
     * @param string $key name of key to check
     *
     * @return bool true, if key exists; false otherwise
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->parameters);
    }

    /**
     * Unsets the given key's value if it's set.
     *
     * @param string $key name of key to unset
     *
     * @return void
     */
    public function offsetUnset($key)
    {
        if (isset($this->parameters[$key])) {
            unset($this->parameters[$key]);
        }
    }

    /**
     * Returns all first level key names.
     *
     * @return array of keys
     */
    public function keys()
    {
        return array_keys($this->parameters);
    }

    /**
     * Returns all first level key names.
     *
     * @return array of keys
     */
    public function getKeys()
    {
        return array_keys($this->parameters);
    }

    /**
     * Adds the given parameters to the current ones.
     *
     * @param array|Parameters $parameters array of key-value pairs or other Parameters instance
     *
     * @return Parameters self instance for fluent API
     */
    public function add($parameters = array())
    {
        if (is_array($parameters)) {
            foreach ($parameters as $key => $value) {
                $this->set($key, $value);
            }
        } elseif ($parameters instanceof Parameters) {
            foreach ($parameters->getKeys() as $key) {
                $this->set($key, $parameters->get($key));
            }
        } else {
            throw new InvalidArgumentException(
                'Given parameters must be of type array or Params\Parameters. ' . gettype($parameters) . ' given.'
            );
        }

        return $this;
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
     * @param string $expression JMESPath expression to evaluate on parameters
     *
     * @return mixed|null data in various types (scalar, array etc.) depending on the found results
     *
     * @throws \JmesPath\SyntaxErrorException on invalid expression syntax
     * @throws \RuntimeException e.g. if JMESPath cache directory cannot be written
     * @throws \InvalidArgumentException e.g. if JMESPath builtin functions can't be called
     */
    public function search($expression = '*')
    {
        return JmesPath::search($expression, $this->parameters);
    }

    /**
     * Returns the data as an associative array.
     *
     * @return array with all data
     */
    public function toArray()
    {
        return $this->parameters;
    }

    /**
     * Delete all key/value pairs.
     */
    public function clear()
    {
        $this->parameters = array();
    }
}
