<small>Params</small>

ConfigurableArrayObject
=======================

Class that extends ArrayObject to be able to allow changes or not.

Description
-----------

It contains methods to more conveniently access or change data.

Signature
---------

- It is a(n) **class**.
- It implements the [`JsonSerializable`](http://php.net/class.JsonSerializable) interface.
- It is a subclass of [`ArrayObject`](http://php.net/class.ArrayObject).

Constants
---------

This class defines the following constants:

- [`OPTION_MUTABLE`](#OPTION_MUTABLE) &mdash; Option key to set to determine whether the current object has mutable data.
- [`OPTION_ITERATOR`](#OPTION_ITERATOR) &mdash; Option key to set the class name of the default iterator to use for data.
- [`DEFAULT_ITERATOR`](#DEFAULT_ITERATOR) &mdash; Default value of the OPTION_ITERATOR.

Methods
-------

The class defines the following methods:

- [`__construct()`](#__construct) &mdash; Create a new instance with the given data as initial value set.
- [`has()`](#has) &mdash; Returns whether the key exists or not.
- [`get()`](#get) &mdash; Returns the value for the given key.
- [`getKeys()`](#getKeys) &mdash; Returns all first level key names.
- [`getValues()`](#getValues) &mdash; Allows to search for specific data values via JMESPath expressions.
- [`set()`](#set) &mdash; Sets a given value for the specified key.
- [`add()`](#add) &mdash; Adds the given data (key/value pairs) to the current data.
- [`remove()`](#remove) &mdash; Removes the given key from the internal array.
- [`clear()`](#clear) &mdash; Deletes all internal data.
- [`map()`](#map) &mdash; Runs given callback for every key on the current level.
- [`toArray()`](#toArray) &mdash; Returns the data as an associative array.
- [`jsonSerialize()`](#jsonSerialize)
- [`__toString()`](#__toString)
- [`offsetGet()`](#offsetGet) &mdash; Returns the value of the specified key.
- [`offsetSet()`](#offsetSet) &mdash; Sets the given data on the specified key.
- [`offsetUnset()`](#offsetUnset) &mdash; Unsets the value of the given key.
- [`append()`](#append) &mdash; Appends the given new value as the last element to the internal data.
- [`exchangeArray()`](#exchangeArray) &mdash; Exchanges the current data array with another array.
- [`getArrayCopy()`](#getArrayCopy) &mdash; Creates a copy of the data as an array.
- [`__clone()`](#__clone) &mdash; Enables deep clones.

### `__construct()` <a name="__construct"></a>

Create a new instance with the given data as initial value set.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$data` (`array`) &mdash; initial data
    - `$options` (`array`)
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

### `set()` <a name="set"></a>

Sets a given value for the specified key.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`mixed`) &mdash; name of entry
    - `$value` (`mixed`) &mdash; value to set for the given key
    - `$replace` (`bool`) &mdash; whether or not to replace values of existing keys
- _Returns:_ self instance for fluent API
    - [`Settings`](../Params/Settings.md)
- It throws one of the following exceptions:
    - [`InvalidArgumentException`](http://php.net/class.InvalidArgumentException) &mdash; on empty string or null key given

### `add()` <a name="add"></a>

Adds the given data (key/value pairs) to the current data.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$data` (`array`) &mdash; associative array or ArrayAccess implementing object
    - `$replace` (`bool`) &mdash; whether or not to replace values of existing keys
- _Returns:_ self instance for fluent API
    - [`Settings`](../Params/Settings.md)
- It throws one of the following exceptions:
    - [`InvalidArgumentException`](http://php.net/class.InvalidArgumentException) &mdash; on wrong data type given

### `remove()` <a name="remove"></a>

Removes the given key from the internal array.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`mixed`) &mdash; name of key to remove
- _Returns:_ self instance for fluent API
    - [`Settings`](../Params/Settings.md)

### `clear()` <a name="clear"></a>

Deletes all internal data.

#### Signature

- It is a **public** method.
- _Returns:_ self instance for fluent API
    - [`Settings`](../Params/Settings.md)

### `map()` <a name="map"></a>

Runs given callback for every key on the current level.

#### Description

The callback
should accept key and value as parameters and return the new value.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$callback` (`mixed`) &mdash; callback to run for each entry of the current level
- _Returns:_ self instance for fluent API
    - [`Settings`](../Params/Settings.md)

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

### `jsonSerialize()` <a name="jsonSerialize"></a>

#### Signature

- It is a **public** method.
- _Returns:_ data which can be serialized by json_encode
    - `array`

### `__toString()` <a name="__toString"></a>

#### Signature

- It is a **public** method.
- _Returns:_ simple representation of the internal array
    - `string`

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

### `offsetUnset()` <a name="offsetUnset"></a>

Unsets the value of the given key.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`mixed`) &mdash; key key to remove
- It returns a(n) `void` value.
- It throws one of the following exceptions:
    - [`LogicException`](http://php.net/class.LogicException) &mdash; on write attempt when modification is forbidden

### `append()` <a name="append"></a>

Appends the given new value as the last element to the internal data.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$value` (`Params\$value`) &mdash; value to append
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

### `getArrayCopy()` <a name="getArrayCopy"></a>

Creates a copy of the data as an array.

#### Signature

- It is a **public** method.
- It does not return anything.

### `__clone()` <a name="__clone"></a>

Enables deep clones.

#### Signature

- It is a **public** method.
- It does not return anything.

