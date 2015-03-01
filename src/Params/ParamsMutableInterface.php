<?php

namespace Params;

/**
 * Interface that defines mutating methods.
 */
interface ParamsMutableInterface
{
    /**
     * Sets a given value for the specified key.
     *
     * @param mixed $key name of entry
     * @param mixed $value value to set for the given key
     * @param bool $replace whether or not to replace values of existing keys
     *
     * @return self instance for fluent API
     *
     * @throws \InvalidArgumentException on empty string or null key given
     */
    public function set($key, $value, $replace = true);

    /**
     * Adds the given data (key/value pairs) to the current data.
     *
     * @param array $data associative array or ArrayAccess implementing object
     * @param bool $replace whether or not to replace values of existing keys
     *
     * @return self instance for fluent API
     */
    public function add($data = [], $replace = true);

    /**
     * Removes the given key from the internal array.
     *
     * @param mixed $key name of key to remove
     *
     * @return self instance for fluent API
     */
    public function remove($key);

    /**
     * Deletes all internal data.
     *
     * @return self instance for fluent API
     */
    public function clear();

    /**
     * Runs given callback for every key on the current level. The callback
     * should accept key and value as parameters and return the new value.
     *
     * @param mixed $callback callback to run for each entry of the current level
     *
     * @return self instance for fluent API
     */
    public function map($callback);
}
