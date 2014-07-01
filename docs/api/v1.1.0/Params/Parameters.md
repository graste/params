<small>Params</small>

Parameters
==========

Class that wraps an associative array for more convenient access of keys and values.

Signature
---------

- It is a(n) **class**.
- It implements the [`JsonSerializable`](http://php.net/class.JsonSerializable) interface.
- It is a subclass of [`ArrayObject`](http://php.net/class.ArrayObject).

Methods
-------

The class defines the following methods:

- [`__construct()`](#__construct) &mdash; Create a new instance with the given data as initial value set.
- [`get()`](#get) &mdash; Returns the value for the given key.
- [`set()`](#set) &mdash; Sets a given value for the specified key.
- [`has()`](#has) &mdash; Returns whether the key exists or not.
- [`remove()`](#remove) &mdash; Removes the given key from the internal array.
- [`offsetGet()`](#offsetGet) &mdash; Returns the value of the specified key.
- [`offsetSet()`](#offsetSet) &mdash; Sets the given data on the specified key.
- [`getArrayCopy()`](#getArrayCopy) &mdash; Creates a copy of the data as an array.
- [`keys()`](#keys) &mdash; Returns all first level key names.
- [`getKeys()`](#getKeys) &mdash; Returns all first level key names.
- [`add()`](#add) &mdash; Adds the given parameters to the current ones.
- [`each()`](#each) &mdash; Runs given callback for every key on the current level.
- [`search()`](#search) &mdash; Allows to search for specific parameters via JMESPath expressions.
- [`toArray()`](#toArray) &mdash; Returns the data as an associative array.
- [`clear()`](#clear) &mdash; Delete all key/value pairs.
- [`__clone()`](#__clone) &mdash; Enables deep clones.
- [`jsonSerialize()`](#jsonSerialize)
- [`__toString()`](#__toString)

### `__construct()` <a name="__construct"></a>

Create a new instance with the given data as initial value set.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$data`
    - `$iterator_class`
- It does not return anything.

### `get()` <a name="get"></a>

Returns the value for the given key.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`string`) &mdash; name of key
    - `$default` (`mixed`) &mdash; value to return if key doesn&#039;t exist
- _Returns:_ value for that key or default given
    - `mixed`

### `set()` <a name="set"></a>

Sets a given value for the specified key.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`string`) &mdash; name of entry
    - `$value` (`mixed`) &mdash; value to set for the given key
    - `$replace` (`bool`) &mdash; whether or not to replace values of existing keys
- _Returns:_ self instance for fluent API
    - [`Parameters`](../Params/Parameters.md)

### `has()` <a name="has"></a>

Returns whether the key exists or not.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`string`) &mdash; name of key to check
- _Returns:_ true, if key exists; false otherwise
    - `bool`

### `remove()` <a name="remove"></a>

Removes the given key from the internal array.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`string`) &mdash; name of key to remove
- _Returns:_ value of the removed key
    - `mixed`
    - `null`

### `offsetGet()` <a name="offsetGet"></a>

Returns the value of the specified key.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`string`) &mdash; name of key to get
- _Returns:_ value or null if non-existant key
    - `mixed`
    - `null`

### `offsetSet()` <a name="offsetSet"></a>

Sets the given data on the specified key.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`string`) &mdash; name of key to set
    - `$data` (`mixed`) &mdash; data to set for the given key
- It returns a(n) `void` value.

### `getArrayCopy()` <a name="getArrayCopy"></a>

Creates a copy of the data as an array.

#### Signature

- It is a **public** method.
- It does not return anything.

### `keys()` <a name="keys"></a>

Returns all first level key names.

#### Signature

- It is a **public** method.
- _Returns:_ of keys
    - `array`

### `getKeys()` <a name="getKeys"></a>

Returns all first level key names.

#### Signature

- It is a **public** method.
- _Returns:_ of keys
    - `array`

### `add()` <a name="add"></a>

Adds the given parameters to the current ones.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$data` (`array`) &mdash; array of key-value pairs or ArrayAccess implementing object
    - `$replace` (`bool`) &mdash; whether or not to replace values of existing keys
- _Returns:_ self instance for fluent API
    - [`Parameters`](../Params/Parameters.md)

### `each()` <a name="each"></a>

Runs given callback for every key on the current level.

#### Description

The callback
should accept key and value as parameters and return the new value.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$callback` (`Params\callback`) &mdash; callback to run for each entry of the current level
- _Returns:_ self instance for fluent API
    - [`Parameters`](../Params/Parameters.md)

### `search()` <a name="search"></a>

Allows to search for specific parameters via JMESPath expressions.

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

### `clear()` <a name="clear"></a>

Delete all key/value pairs.

#### Signature

- It is a **public** method.
- It does not return anything.

### `__clone()` <a name="__clone"></a>

Enables deep clones.

#### Signature

- It is a **public** method.
- It does not return anything.

### `jsonSerialize()` <a name="jsonSerialize"></a>

#### Signature

- It is a **public** method.
- _Returns:_ data which can be serialized by json_encode
    - `array`

### `__toString()` <a name="__toString"></a>

#### Signature

- It is a **public** method.
- _Returns:_ representation of the internal array
    - `string`

