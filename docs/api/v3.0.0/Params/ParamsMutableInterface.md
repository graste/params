<small>Params</small>

ParamsMutableInterface
======================

Interface that defines mutating methods.

Signature
---------

- It is a(n) **interface**.

Methods
-------

The interface defines the following methods:

- [`set()`](#set) &mdash; Sets a given value for the specified key.
- [`add()`](#add) &mdash; Adds the given data (key/value pairs) to the current data.
- [`remove()`](#remove) &mdash; Removes the given key from the internal array.
- [`clear()`](#clear) &mdash; Deletes all internal data.
- [`map()`](#map) &mdash; Runs given callback for every key on the current level.

### `set()` <a name="set"></a>

Sets a given value for the specified key.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`mixed`) &mdash; name of entry
    - `$value` (`mixed`) &mdash; value to set for the given key
    - `$replace` (`bool`) &mdash; whether or not to replace values of existing keys
- _Returns:_ instance for fluent API
    - [`ParamsMutableInterface`](../Params/ParamsMutableInterface.md)
- It throws one of the following exceptions:
    - [`InvalidArgumentException`](http://php.net/class.InvalidArgumentException) &mdash; on empty string or null key given

### `add()` <a name="add"></a>

Adds the given data (key/value pairs) to the current data.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$data` (`array`) &mdash; associative array or ArrayAccess implementing object
    - `$replace` (`bool`) &mdash; whether or not to replace values of existing keys
- _Returns:_ instance for fluent API
    - [`ParamsMutableInterface`](../Params/ParamsMutableInterface.md)

### `remove()` <a name="remove"></a>

Removes the given key from the internal array.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`mixed`) &mdash; name of key to remove
- _Returns:_ instance for fluent API
    - [`ParamsMutableInterface`](../Params/ParamsMutableInterface.md)

### `clear()` <a name="clear"></a>

Deletes all internal data.

#### Signature

- It is a **public** method.
- _Returns:_ instance for fluent API
    - [`ParamsMutableInterface`](../Params/ParamsMutableInterface.md)

### `map()` <a name="map"></a>

Runs given callback for every key on the current level.

#### Description

The callback
should accept key and value as parameters and return the new value.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$callback` (`mixed`) &mdash; callback to run for each entry of the current level
- _Returns:_ instance for fluent API
    - [`ParamsMutableInterface`](../Params/ParamsMutableInterface.md)

