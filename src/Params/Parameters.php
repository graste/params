<?php

namespace Params;

use Params\Immutable\ImmutableParameters;
use InvalidArgumentException;
use ArrayAccess;

/**
 * Class that wraps an associative array for
 * more convenient access of keys and values.
 */
class Parameters extends ImmutableParameters implements ParametersInterface
{
    /**
     * Create a new instance with the given data as initial value set.
     *
     * @param array $data initial data
     * @param string $iterator_class implementor to use for iterator
     */
    public function __construct($data = array(), $iterator_class = 'ArrayIterator')
    {
        parent::__construct($data, $iterator_class);

        $this->allow_modification = true;
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

        $this->offsetSet($key, $value);

        return $this;
    }

    /**
     * Adds the given data (key/value pairs) to the current data.
     *
     * @param array $data associative array or ArrayAccess implementing object
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
                'Data must be of type array or implement ArrayAccess. Type given: ' . gettype($data)
            );
        }

        return $this;
    }

    /**
     * Removes the given key from the internal array.
     *
     * @param string $key name of key to remove
     *
     * @return Parameters self instance for fluent API
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
     * @return Parameters self instance for fluent API
     */
    public function clear()
    {
        $this->exchangeArray(array());

        return $this;
    }

    /**
     * Runs given callback for every key on the current level. The callback
     * should accept key and value as parameters and return the new value.
     *
     * @param mixed $callback callback to run for each entry of the current level
     *
     * @return Parameters self instance for fluent API
     */
    public function map($callback)
    {
        foreach ($this as $key => $value) {
            $this->set($key, call_user_func($callback, $key, $value));
        }

        return $this;
    }
}
