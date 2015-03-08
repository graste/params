<small>Params</small>

OptionsTrait
============

Trait that contains an Options instance to use for nestable configuration options.

Signature
---------

- It is a(n) **class**.

Methods
-------

The class defines the following methods:

- [`setOption()`](#setOption) &mdash; Sets a given value for the specified key.
- [`addOptions()`](#addOptions) &mdash; Adds the given data (key/value pairs) to the current data.
- [`removeOption()`](#removeOption) &mdash; Removes the given key from the internal array.
- [`clearOptions()`](#clearOptions) &mdash; Delete all internal data.
- [`setOptions()`](#setOptions) &mdash; Set an object&#039;s options.

### `setOption()` <a name="setOption"></a>

Sets a given value for the specified key.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`mixed`) &mdash; name of entry
    - `$value` (`mixed`) &mdash; value to set for the given key
    - `$replace` (`bool`) &mdash; whether or not to replace values of existing keys
- _Returns:_ self instance for fluent API
    - [`Options`](../Params/Options.md)
- It throws one of the following exceptions:
    - [`InvalidArgumentException`](http://php.net/class.InvalidArgumentException) &mdash; on empty string or null key given

### `addOptions()` <a name="addOptions"></a>

Adds the given data (key/value pairs) to the current data.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$data` (`array`|[`ConfigurableArrayObject`](../Params/ConfigurableArrayObject.md)) &mdash; associative array or ConfigurableArrayObject implementing object
    - `$replace` (`bool`) &mdash; whether or not to replace values of existing keys
- _Returns:_ self instance for fluent API
    - [`Options`](../Params/Options.md)
- It throws one of the following exceptions:
    - [`InvalidArgumentException`](http://php.net/class.InvalidArgumentException) &mdash; on wrong data type given

### `removeOption()` <a name="removeOption"></a>

Removes the given key from the internal array.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`mixed`) &mdash; name of key to remove
- _Returns:_ self instance for fluent API
    - [`Options`](../Params/Options.md)

### `clearOptions()` <a name="clearOptions"></a>

Delete all internal data.

#### Signature

- It is a **public** method.
- _Returns:_ self instance for fluent API
    - [`Options`](../Params/Options.md)

### `setOptions()` <a name="setOptions"></a>

Set an object&#039;s options.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$options` (`array`|[`ConfigurableArrayObject`](../Params/ConfigurableArrayObject.md)) &mdash; Either array or ConfigurableArrayObject implementing object.
- It does not return anything.
- It throws one of the following exceptions:
    - [`InvalidArgumentException`](http://php.net/class.InvalidArgumentException) &mdash; on wrong data type given

