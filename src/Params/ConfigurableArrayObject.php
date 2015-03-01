<?php

namespace Params;

use ArrayAccess;
use ArrayObject;
use InvalidArgumentException;
use JmesPath\Env as JmesPath;
use JsonSerializable;
use LogicException;

/**
 * Class that extends ArrayObject to be able to allow changes or not.
 * It contains methods to more conveniently access or change data.
 */
class ConfigurableArrayObject extends ArrayObject implements JsonSerializable
{
    /**
     * Option key to set to determine whether the current object has mutable data.
     */
    const OPTION_MUTABLE = 'mutable';

    /**
     * Option key to set the class name of the default iterator to use for data.
     */
    const OPTION_ITERATOR = 'iterator';

    /**
     * Default value of the OPTION_ITERATOR.
     */
    const DEFAULT_ITERATOR = 'ArrayIterator';

    /**
     * @var string default iterator used
     */
    protected $iterator_class_name = self::DEFAULT_ITERATOR;

    /**
     * @var bool whether changing data is allowed or not
     */
    protected $allow_modification = false;

    /**
     * Create a new instance with the given data as initial value set.
     *
     * @param array $data initial data
     * @param array $options
     */
    public function __construct(array $data = [], array $options = [])
    {
        if (array_key_exists(self::OPTION_ITERATOR, $options)) {
            $this->iterator_class_name = trim($options[self::OPTION_ITERATOR]);
        }

        if (!class_exists($this->iterator_class_name)) {
            throw new InvalidArgumentException(
                'Given iterator class name must match an existing class. Autoloading correctly configured?'
            );
        }

        $this->allow_modification = true;

        parent::__construct([], self::ARRAY_AS_PROPS, $this->iterator_class_name);

        foreach ($data as $key => $value) {
            $this->offsetSet($key, $value);
        }

        // allow this object to have mutable data after initial data set import?
        if (array_key_exists(self::OPTION_MUTABLE, $options)) {
            $this->allow_modification = $this->toBoolean($options[self::OPTION_MUTABLE]);
        }
    }

    /**
     * Returns whether the key exists or not.
     *
     * @param mixed $key name of key to check
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
     * @param mixed $key name of key
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
     * Sets a given value for the specified key.
     *
     * @param mixed $key name of entry
     * @param mixed $value value to set for the given key
     * @param bool $replace whether or not to replace values of existing keys
     *
     * @return Settings self instance for fluent API
     *
     * @throws \InvalidArgumentException on empty string or null key given
     */
    public function set($key, $value, $replace = true)
    {
        if (is_null($key) || '' === $key) {
            throw new InvalidArgumentException('Invalid key given (null and empty string are not allowed).');
        }

        if (!$replace && $this->offsetExists($key)) {
            return;
        }

        $this->offsetSet($key, $value);

        return $this;
    }

    /**
     * Adds the given data (key/value pairs) to the current data.
     *
     * @param array $data associative array or ArrayAccess implementing object
     * @param bool $replace whether or not to replace values of existing keys
     *
     * @return Settings self instance for fluent API
     *
     * @throws \InvalidArgumentException on wrong data type given
     */
    public function add($data = [], $replace = true)
    {
        if (is_array($data) || $data instanceof ArrayAccess) {
            foreach ($data as $key => $value) {
                $this->set($key, $value, $replace);
            }
        } else {
            throw new InvalidArgumentException(
                'Data must be an array or implement ArrayAccess. Type given: ' . gettype($data)
            );
        }

        return $this;
    }

    /**
     * Removes the given key from the internal array.
     *
     * @param mixed $key name of key to remove
     *
     * @return Settings self instance for fluent API
     */
    public function remove($key)
    {
        if ($this->offsetExists($key)) {
            $this->offsetUnset($key);
        }

        return $this;
    }

    /**
     * Deletes all internal data.
     *
     * @return Settings self instance for fluent API
     */
    public function clear()
    {
        $this->exchangeArray([]);

        return $this;
    }

    /**
     * Runs given callback for every key on the current level. The callback
     * should accept key and value as parameters and return the new value.
     *
     * @param mixed $callback callback to run for each entry of the current level
     *
     * @return Settings self instance for fluent API
     */
    public function map($callback)
    {
        foreach ($this as $key => $value) {
            $this->set($key, call_user_func($callback, $key, $value));
        }

        return $this;
    }

    /**
     * Returns the data as an associative array.
     *
     * @param bool $recursive whether or not nested arrays should be included as array or object
     *
     * @return array with all data
     *
     * @throws \InvalidArgumentException when no toArray method is available on objects
     */
    public function toArray($recursive = true)
    {
        $data = [];

        foreach ($this as $key => $value) {
            if ($recursive && is_object($value)) {
                if (!is_callable([$value, 'toArray'])) {
                    throw new InvalidArgumentException('Object does not implement toArray() method on key: ' . $key);
                }
                $data[$key] = $value->toArray();
            } else {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * @return array data which can be serialized by json_encode
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @return string simple representation of the internal array
     */
    public function __toString()
    {
        return (string)var_export($this->toArray(), true);
    }


    //
    // overridden ArrayObject methods (to prevent modification if necessary)
    //


    /**
     * Returns the value of the specified key.
     *
     * @param mixed $key name of key to get
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
     * @param mixed $key name of key to set
     * @param mixed $data data to set for the given key
     *
     * @return void
     *
     * @throws \LogicException on write attempt when modification is forbidden
     */
    public function offsetSet($key, $data)
    {
        if (!$this->allow_modification) {
            throw new LogicException('Attempting to write to an immutable array.');
        }

        if (isset($data) && is_array($data)) {
            $data = new static($data);
        }

        return parent::offsetSet($key, $data);
    }

    /**
     * Unsets the value of the given key.
     *
     * @param mixed key key to remove
     *
     * @return void
     *
     * @throws \LogicException on write attempt when modification is forbidden
     */
    public function offsetUnset($key)
    {
        if (!$this->allow_modification) {
            throw new LogicException('Attempting to unset key on an immutable array.');
        }

        if ($this->offsetExists($key)) {
            parent::offsetUnset($key);
        }
    }

    /**
     * Appends the given new value as the last element to the internal data.
     *
     * @param $value value to append
     *
     * @return void
     *
     * @throws \LogicException on write attempt when modification is forbidden
     */
    public function append($value)
    {
        if (!$this->allow_modification) {
            throw new LogicException('Attempting to append to an immutable array.');
        }

        return parent::append($value);
    }

    /**
     * Exchanges the current data array with another array.
     *
     * @param array $data array with key-value pairs to set as new data
     *
     * @return array old data
     *
     * @throws \LogicException on write attempt when modification is forbidden
     */
    public function exchangeArray($data)
    {
        if (!$this->allow_modification) {
            throw new LogicException('Attempting to exchange data of an immutable array.');
        }

        return parent::exchangeArray($data);
    }

    /**
     * Creates a copy of the data as an array.
     */
    public function getArrayCopy()
    {
        return $this->toArray();
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
     * @param mixed $value value to be interpreted as boolean
     *
     * @return boolean
     */
    protected function toBoolean($value)
    {
        $bool = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if (null === $bool) {
            return false;
        }
        return $bool;
    }
}
