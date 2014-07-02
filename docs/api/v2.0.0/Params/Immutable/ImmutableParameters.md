<small>Params\Immutable</small>

ImmutableParameters
===================

Class that gives recursive read-only access to parameters added via constructor.

Signature
---------

- It is a(n) **class**.
- It implements the following interfaces:
    - [`JsonSerializable`](http://php.net/class.JsonSerializable)
    - [`Params\Immutable\ImmutableParametersInterface`](../../Params/Immutable/ImmutableParametersInterface.md) &mdash; Marker interface for a class that wraps an associative array for more convenient access of keys and values while the actual values are not mutable via methods like set, add, remove etc.
- It is a subclass of [`ArrayObject`](http://php.net/class.ArrayObject).

Methods
-------

The class defines the following methods:

- [`__construct()`](#__construct) &mdash; Create a new instance with the given data as initial value set.
- [`has()`](#has) &mdash; Returns whether the key exists or not.
- [`get()`](#get) &mdash; Returns the value for the given key.
- [`getKeys()`](#getKeys) &mdash; Returns all first level key names.
- [`getValues()`](#getValues) &mdash; Allows to search for specific data values via JMESPath expressions.
- [`toArray()`](#toArray) &mdash; Returns the data as an associative array.
- [`offsetGet()`](#offsetGet) &mdash; Returns the value of the specified key.
- [`offsetSet()`](#offsetSet) &mdash; Sets the given data on the specified key.
- [`getArrayCopy()`](#getArrayCopy) &mdash; Creates a copy of the data as an array.
- [`append()`](#append) &mdash; Appends the given new value as the last element to the internal data.
- [`exchangeArray()`](#exchangeArray) &mdash; Exchanges the current data array with another array.
- [`offsetUnset()`](#offsetUnset) &mdash; Unsets the value of the given key.
- [`jsonSerialize()`](#jsonSerialize)
- [`__clone()`](#__clone) &mdash; Enables deep clones.
- [`__toString()`](#__toString)

### `__construct()` <a name="__construct"></a>

Create a new instance with the given data as initial value set.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$data` (`array`) &mdash; initial data
    - `$iterator_class` (`string`) &mdash; implementor to use for iterator
- It does not return anything.

### `has()` <a name="has"></a>

Returns whether the key exists or not.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`mixed`) &mdash; name of key to check
- _Returns:_ true, if key exists; false otherwise
    - `bool`

### `get()` <a name="get"></a>

Returns the value for the given key.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`mixed`) &mdash; name of key
    - `$default` (`mixed`) &mdash; value to return if key doesn&#039;t exist
- _Returns:_ value for that key or default given
    - `mixed`

### `getKeys()` <a name="getKeys"></a>

Returns all first level key names.

#### Signature

- It is a **public** method.
- _Returns:_ of keys
    - `array`

### `getValues()` <a name="getValues"></a>

Allows to search for specific data values via JMESPath expressions.

#### Description

Some example expressions as a quick start:

- &quot;nested.key&quot;           returns the value of the nested &quot;key&quot;
- &quot;nested.*&quot;             returns all values available under the &quot;nested&quot; key
- &quot;*.key&quot;                returns all values of &quot;key&quot;s on any second level array
- &quot;[key, nested.key]&quot;    returns first level &quot;key&quot; value and the first value of the &quot;nested&quot; key array
- &quot;[key, nested[0]&quot;      returns first level &quot;key&quot; value and the first value of the &quot;nested&quot; key array
- &quot;nested.key || key&quot;    returns the value of the first matching expression

#### See Also

- `http://jmespath.readthedocs.org/en/latest/` &mdash; and https://github.com/mtdowling/jmespath.php

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$expression` (`string`) &mdash; JMESPath expression to evaluate on stored data
- _Returns:_ data in various types (scalar, array etc.) depending on the found results
    - `mixed`
    - `null`
- It throws one of the following exceptions:
    - `JmesPath\SyntaxErrorException` &mdash; on invalid expression syntax
    - [`RuntimeException`](http://php.net/class.RuntimeException) &mdash; e.g. if JMESPath cache directory cannot be written
    - [`InvalidArgumentException`](http://php.net/class.InvalidArgumentException) &mdash; e.g. if JMESPath builtin functions can&#039;t be called

### `toArray()` <a name="toArray"></a>

Returns the data as an associative array.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$recursive` (`bool`) &mdash; whether or not nested arrays should be included as array or object
- _Returns:_ with all data
    - `array`
- It throws one of the following exceptions:
    - [`InvalidArgumentException`](http://php.net/class.InvalidArgumentException) &mdash; when no toArray method is available on objects

### `offsetGet()` <a name="offsetGet"></a>

Returns the value of the specified key.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`mixed`) &mdash; name of key to get
- _Returns:_ value or null if non-existant key
    - `mixed`
    - `null`

### `offsetSet()` <a name="offsetSet"></a>

Sets the given data on the specified key.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`mixed`) &mdash; name of key to set
    - `$data` (`mixed`) &mdash; data to set for the given key
- It returns a(n) `void` value.
- It throws one of the following exceptions:
    - [`LogicException`](http://php.net/class.LogicException) &mdash; on write attempt when modification is forbidden

### `getArrayCopy()` <a name="getArrayCopy"></a>

Creates a copy of the data as an array.

#### Signature

- It is a **public** method.
- It does not return anything.

### `append()` <a name="append"></a>

Appends the given new value as the last element to the internal data.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$value` (`Params\Immutable\$value`) &mdash; value to append
- It returns a(n) `void` value.
- It throws one of the following exceptions:
    - [`LogicException`](http://php.net/class.LogicException) &mdash; on write attempt when modification is forbidden

### `exchangeArray()` <a name="exchangeArray"></a>

Exchanges the current data array with another array.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$data` (`array`) &mdash; array with key-value pairs to set as new data
- _Returns:_ old data
    - `array`
- It throws one of the following exceptions:
    - [`LogicException`](http://php.net/class.LogicException) &mdash; on write attempt when modification is forbidden

### `offsetUnset()` <a name="offsetUnset"></a>

Unsets the value of the given key.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`mixed`) &mdash; key key to remove
- It returns a(n) `void` value.
- It throws one of the following exceptions:
    - [`LogicException`](http://php.net/class.LogicException) &mdash; on write attempt when modification is forbidden

### `jsonSerialize()` <a name="jsonSerialize"></a>

#### Signature

- It is a **public** method.
- _Returns:_ data which can be serialized by json_encode
    - `array`

### `__clone()` <a name="__clone"></a>

Enables deep clones.

#### Signature

- It is a **public** method.
- It does not return anything.

### `__toString()` <a name="__toString"></a>

#### Signature

- It is a **public** method.
- _Returns:_ simple representation of the internal array
    - `string`

