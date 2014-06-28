<small>Params</small>

Parameters
==========

Class that wraps an associative array for more convenient access of keys and values.

Signature
---------

- It is a(n) **class**.
- It implements the [`ArrayAccess`](http://php.net/class.ArrayAccess) interface.

Methods
-------

The class defines the following methods:

- [`__construct()`](#__construct) &mdash; Create a new instance with the given parameters as initial value set.
- [`get()`](#get) &mdash; Returns the value for the given key.
- [`set()`](#set) &mdash; Sets a given value for the specified key.
- [`has()`](#has) &mdash; Returns whether the key exists or not.
- [`offsetSet()`](#offsetSet)
- [`offsetGet()`](#offsetGet)
- [`offsetExists()`](#offsetExists) &mdash; Returns whether the key exists or not.
- [`offsetUnset()`](#offsetUnset) &mdash; Unsets the given key&#039;s value if it&#039;s set.
- [`keys()`](#keys) &mdash; Returns all first level key names.
- [`getKeys()`](#getKeys) &mdash; Returns all first level key names.
- [`add()`](#add) &mdash; Adds the given parameters to the current ones.
- [`search()`](#search) &mdash; Allows to search for specific parameters via JMESPath expressions.
- [`toArray()`](#toArray) &mdash; Returns the data as an associative array.
- [`clear()`](#clear) &mdash; Delete all key/value pairs.

### `__construct()` <a name="__construct"></a>

Create a new instance with the given parameters as initial value set.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$parameters` (`array`)
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

### `offsetSet()` <a name="offsetSet"></a>

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`string`) &mdash; name of key
    - `$value` (`mixed`) &mdash; value to set for key
- It does not return anything.

### `offsetGet()` <a name="offsetGet"></a>

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`string`) &mdash; name of key
- _Returns:_ value of that key
    - `mixed`
- It throws one of the following exceptions:
    - [`InvalidArgumentException`](http://php.net/class.InvalidArgumentException) &mdash; if key does not exist

### `offsetExists()` <a name="offsetExists"></a>

Returns whether the key exists or not.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`string`) &mdash; name of key to check
- _Returns:_ true, if key exists; false otherwise
    - `bool`

### `offsetUnset()` <a name="offsetUnset"></a>

Unsets the given key&#039;s value if it&#039;s set.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`string`) &mdash; name of key to unset
- It returns a(n) `void` value.

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
    - `$parameters` (`array`|[`Parameters`](../Params/Parameters.md)) &mdash; array of key-value pairs or other Parameters instance
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
    - `$expression` (`string`) &mdash; JMESPath expression to evaluate on parameters
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
- _Returns:_ with all data
    - `array`

### `clear()` <a name="clear"></a>

Delete all key/value pairs.

#### Signature

- It is a **public** method.
- It does not return anything.

