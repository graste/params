<?php

namespace Params;

use Params\Immutable\ImmutableParametersInterface;

/**
 * Class that wraps an associative array for
 * more convenient access of keys and values.
 */
interface ParametersInterface extends ImmutableParametersInterface
{
    /**
     * Sets a given value for the specified key.
     *
     * @param string $key name of entry
     * @param mixed $value value to set for the given key
     * @param bool $replace whether or not to replace values of existing keys
     *
     * @return Parameters self instance for fluent API
     */
    public function set($key, $value, $replace = true);

    /**
     * Adds the given data (key/value pairs) to the current data.
     *
     * @param array $data associative array or ArrayAccess implementing object
     * @param bool $replace whether or not to replace values of existing keys
     *
     * @return Parameters self instance for fluent API
     */
    public function add($data = array(), $replace = true);

    /**
     * Removes the given key from the internal array.
     *
     * @param string $key name of key to remove
     *
     * @return Parameters self instance for fluent API
     */
    public function remove($key);

    /**
     * Deletes all internal data.
     *
     * @return Parameters self instance for fluent API
     */
    public function clear();

    /**
     * Runs given callback for every key on the current level. The callback
     * should accept key and value as parameters and return the new value.
     *
     * @param mixed $callback callback to run for each entry of the current level
     *
     * @return Parameters self instance for fluent API
     */
    public function map($callback);
}
