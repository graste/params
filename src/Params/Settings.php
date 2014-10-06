<?php

namespace Params;

use Params\Immutable\ImmutableSettings;
use InvalidArgumentException;
use ArrayAccess;

/**
 * Class that wraps an associative array for
 * more convenient access of keys and values.
 */
class Settings extends ImmutableSettings implements SettingsInterface
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
        $this->exchangeArray(array());

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
}
