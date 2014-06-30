<?php

namespace Params;

use JmesPath\Env as JmesPath;
use InvalidArgumentException;
use ArrayAccess;
use ArrayObject;

/**
 * Class that wraps an associative array for
 * more convenient access of keys and values.
 */
class Parameters extends ArrayObject
{
    protected $iterator_class = 'ArrayIterator';

    /**
     * Create a new instance with the given data as initial value set.
     *
     * @param array $data
     */
    public function __construct($data = array(), $iterator_class = 'ArrayIterator')
    {
        if (!empty($iterator_class)) {
            $this->iterator_class = trim($iterator_class);
        }

        parent::__construct($data, self::ARRAY_AS_PROPS, $this->iterator_class);
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
        if ($this->offsetExists($key)) {
            return $this[$key];
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

        $this[$key] = $value;

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
        return $this->offsetExists($key);
    }

    /**
     * Removes the given key from the internal array.
     *
     * @param string $key name of key to remove
     *
     * @return mixed|null value of the removed key
     */
    public function remove($key)
    {
        $value = null;

        if ($this->offsetExists($key)) {
            $value = $this[$key];
            unset($this[$key]);
        }

        return $value;
    }

    public function offsetSet($offset, $data)
    {
        if (isset($data) && is_array($data)) {
            $data = new static($data);
        }

        return parent::offsetSet($k, $v);
    }

    /**
     * Returns all first level key names.
     *
     * @return array of keys
     */
    public function keys()
    {
        return array_keys($this);
    }

    /**
     * Returns all first level key names.
     *
     * @return array of keys
     */
    public function getKeys()
    {
        return array_keys($this);
    }

    /**
     * Adds the given parameters to the current ones.
     *
     * @param array $data array of key-value pairs
     *
     * @return Parameters self instance for fluent API
     */
    public function add($data = array())
    {
        if (isset($data) && $data instanceof ArrayAccess) {
            foreach ($data as $key => $value) {
                $this->set($key, $value);
            }
        } else {
            throw new InvalidArgumentException(
                'Given parameters must be of type array or implement ArrayAccess. ' . gettype($data) . ' given.'
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
     * @param string $expression JMESPath expression to evaluate on stored data
     *
     * @return mixed|null data in various types (scalar, array etc.) depending on the found results
     *
     * @throws \JmesPath\SyntaxErrorException on invalid expression syntax
     * @throws \RuntimeException e.g. if JMESPath cache directory cannot be written
     * @throws \InvalidArgumentException e.g. if JMESPath builtin functions can't be called
     */
    public function search($expression = '*')
    {
        return JmesPath::search($expression, $this->toArray());
    }

    /**
     * Returns the data as an associative array.
     *
     * @return array with all data
     */
    public function toArray()
    {
        $data = array();

        foreach ($this as $key => $value) {
            if (is_object($value) && is_callable(array($value, 'toArray'))) {
                $data[$key] = $value->toArray();
            } else {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * Delete all key/value pairs.
     */
    public function clear()
    {
        foreach($this as $entry) {
            unset($entry);
        }
    }
}
