<?php

namespace Params\Immutable;

use Params\Immutable\ImmutableParametersInterface;
use JmesPath\Env as JmesPath;
use JsonSerializable;
use InvalidArgumentException;
use ArrayAccess;
use ArrayObject;

/**
 * Class that behaves as Parameters, but hides the methods that would
 * allow modifications to the data the instance was constructed with.
 */
class ImmutableParameters extends ArrayObject implements JsonSerializable, ImmutableParametersInterface
{
    protected $iterator_class = 'ArrayIterator';

    protected $allow_modification = false;

    /**
     * Create a new instance with the given data as initial value set.
     *
     * @param array $data initial data
     * @param string $iterator_class implementor to use for iterator
     */
    public function __construct($data = array(), $iterator_class = 'ArrayIterator')
    {
        if (!empty($iterator_class)) {
            $this->iterator_class = trim($iterator_class);
        }

        $this->allow_modification = true;

        parent::__construct(array(), self::ARRAY_AS_PROPS, $this->iterator_class);

        foreach ($data as $key => $value) {
            $this->offsetSet($key, $value);
        }

        $this->allow_modification = false;
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
            return $this->offsetGet($key);
        }

        return $default;
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
    public function getValues($expression = '*')
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
            if ($recursive && is_object($value)) {
                if (!is_callable(array($value, 'toArray'))) {
                    throw new InvalidArgumentException('Object does not implement toArray() method on key: ' . $key);
                }
                $data[$key] = $value->toArray();
            } else {
                $data[$key] = $value;
            }
        }

        return $data;
    }


    //
    // overridden ArrayObject methods
    //


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
        if (!$this->allow_modification) {
            throw new LogicException('Attempting to write to an immutable array');
        }

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

    public function append($value)
    {
        if (!$this->allow_modification) {
            throw new LogicException('Attempting to write to an immutable array');
        }

        return parent::append($value);
    }

    public function exchangeArray($data)
    {
        if (!$this->allow_modification) {
            throw new LogicException('Attempting to write to an immutable array');
        }

        return parent::exchangeArray($data);
    }

    public function offsetUnset($key)
    {
        if (!$this->allow_modification) {
            throw new LogicException('Attempting to write to an immutable array');
        }

        return parent::offsetUnset($key);
    }

    /**
     * @return array data which can be serialized by json_encode
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /* todo serialize/unserialize?
    public function serialize() {
        return serialize($this->data);
    }
    public function unserialize($data) {
        $this->data = unserialize($data);
    }*/

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
     * @return string simple representation of the internal array
     */
    public function __toString()
    {
        return (string)var_export($this->toArray(), true);
    }
}
