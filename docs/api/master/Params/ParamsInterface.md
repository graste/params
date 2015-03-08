<small>Params</small>

ParamsInterface
===============

Interface for a class that wraps an associative array for more convenient access of keys and values while the actual values are not mutable via methods like set, add, remove etc.

Signature
---------

- It is a(n) **interface**.

Methods
-------

The interface defines the following methods:

- [`has()`](#has) &mdash; Returns whether the key exists or not.
- [`get()`](#get) &mdash; Returns the value for the given key.
- [`getKeys()`](#getKeys) &mdash; Returns all first level key names.
- [`getValues()`](#getValues) &mdash; Allows to search for specific data values via JMESPath expressions.
- [`toArray()`](#toArray) &mdash; Returns the data as an associative array.

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

- `http://jmespath.readthedocs.org/en/latest/`
- `https://github.com/mtdowling/jmespath.php`

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
- _Returns:_ of all data
    - `array`

