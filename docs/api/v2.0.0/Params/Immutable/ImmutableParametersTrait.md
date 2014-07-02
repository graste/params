<small>Params\Immutable</small>

ImmutableParametersTrait
========================

Trait that contains an ImmutableParameters instance to use for nestable configuration parameters.

Signature
---------

- It is a(n) **class**.

Methods
-------

The class defines the following methods:

- [`hasParameter()`](#hasParameter) &mdash; Returns whether the parameter exists or not.
- [`getParameter()`](#getParameter) &mdash; Returns the value for the given key.
- [`getParameterValues()`](#getParameterValues) &mdash; Allows to search for specific data values via JMESPath expressions.
- [`getParametersAsArray()`](#getParametersAsArray) &mdash; Returns the data as an associative array.
- [`getParameters()`](#getParameters) &mdash; Return this object&#039;s immutable parameters instance.

### `hasParameter()` <a name="hasParameter"></a>

Returns whether the parameter exists or not.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`mixed`) &mdash; key to check
- _Returns:_ true, if key exists; false otherwise
    - `bool`

### `getParameter()` <a name="getParameter"></a>

Returns the value for the given key.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`mixed`) &mdash; key to get value of
    - `$default` (`mixed`) &mdash; value to return if key doesn&#039;t exist
- _Returns:_ value for that key or default given
    - `mixed`

### `getParameterValues()` <a name="getParameterValues"></a>

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

### `getParametersAsArray()` <a name="getParametersAsArray"></a>

Returns the data as an associative array.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$recursive` (`bool`) &mdash; whether or not nested arrays should be included as array or object
- _Returns:_ with all data
    - `array`

### `getParameters()` <a name="getParameters"></a>

Return this object&#039;s immutable parameters instance.

#### Signature

- It is a **public** method.
- _Returns:_ instance used internally
    - [`ImmutableParameters`](../../Params/Immutable/ImmutableParameters.md)

