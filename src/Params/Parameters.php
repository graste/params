<?php

namespace Params;

use JmesPath\Env as JmesPath;
use JsonSerializable;
use InvalidArgumentException;
use ArrayAccess;
use ArrayObject;

/**
 * Class that wraps an associative array for
 * more convenient access of keys and values.
 */
class Parameters extends ArrayObject implements JsonSerializable
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

        parent::__construct(array(), self::ARRAY_AS_PROPS, $this->iterator_class);

        foreach ($data as $key => $value) {
            if (isset($value) && is_array($value)) {
                $value = new static($value);
            }
            $this->offsetSet($key, $value);
        }
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
     * @param bool $replace whether or not to replace values of existing keys
     *
     * @return Parameters self instance for fluent API
     */
    public function set($key, $value, $replace = true)
    {
        if (is_null($key) || '' === $key) {
            throw new InvalidArgumentException('Invalid key given (null and empty string are not allowed).');
        }

        if (!$replace && $this->offsetExists($key)) {
            return;
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
            $this->offsetUnset($key);
        }

        return $value;
    }

    /**
     * Returns the value of the specified key.
     *
     * @param string $key name of key to get
     *
     * @return mixed|null value or null if non-existant key
     */
    public function offsetGet($key)
    {
        if (!$this->offsetExists($key)) {
            return null;
        }

        return parent::offsetGet($key);
    }

    /**
     * Sets the given data on the specified key.
     *
     * @param string $key name of key to set
     * @param mixed $data data to set for the given key
     *
     * @return void
     */
    public function offsetSet($key, $data)
    {
        if (isset($data) && is_array($data)) {
            $data = new static($data);
        }

        return parent::offsetSet($key, $data);
    }

    /**
     * Creates a copy of the data as an array.
     */
    public function getArrayCopy()
    {
        return $this->toArray();
    }

    /**
     * Returns all first level key names.
     *
     * @return array of keys
     */
    public function keys()
    {
        return array_keys((array)$this);
    }

    /**
     * Returns all first level key names.
     *
     * @return array of keys
     */
    public function getKeys()
    {
        return array_keys((array)$this);
    }

    /**
     * Adds the given parameters to the current ones.
     *
     * @param array $data array of key-value pairs or ArrayAccess implementing object
     * @param bool $replace whether or not to replace values of existing keys
     *
     * @return Parameters self instance for fluent API
     */
    public function add($data = array(), $replace = true)
    {
        if (is_array($data) || $data instanceof ArrayAccess) {
            foreach ($data as $key => $value) {
                $this->set($key, $value, $replace);
            }
        } else {
            throw new InvalidArgumentException(
                'Given data must be of type array or implement ArrayAccess. ' . gettype($data) . ' given.'
            );
        }

        return $this;
    }

    /**
     * Runs given callback for every key on the current level. The callback
     * should accept key and value as parameters and return the new value.
     *
     * @param callback $callback callback to run for each entry of the current level
     *
     * @return Parameters self instance for fluent API
     */
    public function each($callback)
    {
        if (is_callable($callback)) {
            foreach ($this as $key => $value) {
                $this->set($key, $callback($key, $value));
            }
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
     * @param bool $recursive whether or not nested arrays should be included as array or object
     *
     * @return array with all data
     */
    public function toArray($recursive = true)
    {
        $data = array();

        foreach ($this as $key => $value) {
            if (is_object($value) && $recursive && is_callable(array($value, 'toArray'))) {
                $data[$key] = $value->toArray();
            } else {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * Delete all key/value pairs.
     *
     * @return Parameters instance
     */
    public function clear()
    {
        $this->exchangeArray(array());
        return $this;
    }

    /**
     * Enables deep clones.
     */
    public function __clone()
    {
        foreach ($this as $key => $value) {
            if (is_object($value)) {
                $this[$key] = clone $value;
            }
        }
    }

    /**
     * @return array data which can be serialized by json_encode
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @return string representation of the internal array
     */
    public function __toString()
    {
        return (string)var_export($this->toArray(), true);
    }
}
