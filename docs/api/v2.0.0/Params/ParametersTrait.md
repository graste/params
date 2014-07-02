<small>Params</small>

ParametersTrait
===============

Trait that contains a Parameters instance to use for nestable configuration parameters.

Signature
---------

- It is a(n) **class**.

Methods
-------

The class defines the following methods:

- [`setParameter()`](#setParameter) &mdash; Sets a given value for the specified key.
- [`addParameters()`](#addParameters) &mdash; Adds the given data (key/value pairs) to the current data.
- [`removeParameter()`](#removeParameter) &mdash; Removes the given key from the internal array.
- [`clearParameters()`](#clearParameters) &mdash; Delete all internal data.
- [`setParameters()`](#setParameters) &mdash; Set an object&#039;s parameters.

### `setParameter()` <a name="setParameter"></a>

Sets a given value for the specified key.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`mixed`) &mdash; name of entry
    - `$value` (`mixed`) &mdash; value to set for the given key
    - `$replace` (`bool`) &mdash; whether or not to replace values of existing keys
- _Returns:_ self instance for fluent API
    - [`Parameters`](../Params/Parameters.md)
- It throws one of the following exceptions:
    - [`InvalidArgumentException`](http://php.net/class.InvalidArgumentException) &mdash; on empty string or null key given

### `addParameters()` <a name="addParameters"></a>

Adds the given data (key/value pairs) to the current data.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$data` (`array`) &mdash; associative array or ArrayAccess implementing object
    - `$replace` (`bool`) &mdash; whether or not to replace values of existing keys
- _Returns:_ self instance for fluent API
    - [`Parameters`](../Params/Parameters.md)
- It throws one of the following exceptions:
    - [`InvalidArgumentException`](http://php.net/class.InvalidArgumentException) &mdash; on wrong data type given

### `removeParameter()` <a name="removeParameter"></a>

Removes the given key from the internal array.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`mixed`) &mdash; name of key to remove
- _Returns:_ self instance for fluent API
    - [`Parameters`](../Params/Parameters.md)

### `clearParameters()` <a name="clearParameters"></a>

Delete all internal data.

#### Signature

- It is a **public** method.
- _Returns:_ self instance for fluent API
    - [`Parameters`](../Params/Parameters.md)

### `setParameters()` <a name="setParameters"></a>

Set an object&#039;s parameters.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$parameters` (`mixed`) &mdash; Either array or ArrayAccess implementing object.
- It does not return anything.
- It throws one of the following exceptions:
    - [`InvalidArgumentException`](http://php.net/class.InvalidArgumentException) &mdash; on wrong data type given

