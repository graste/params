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

- [`getParameter()`](#getParameter) &mdash; Returns the parameter value for the given parameter key.
- [`hasParameter()`](#hasParameter) &mdash; Returns whether the parameter exists or not.
- [`setParameter()`](#setParameter) &mdash; Sets a given value for the specified parameter.
- [`removeParameter()`](#removeParameter) &mdash; Removes the given parameter.
- [`clearParameters()`](#clearParameters) &mdash; Delete all parameters.
- [`addParameters()`](#addParameters) &mdash; Adds the given parameters to the current ones.
- [`getParameterKeys()`](#getParameterKeys) &mdash; Returns all the first level key names.
- [`searchParameters()`](#searchParameters) &mdash; Allows to search for specific parameters via JMESPath expressions.
- [`getParametersAsArray()`](#getParametersAsArray) &mdash; Returns the parameters data as an associative array.
- [`getParameters()`](#getParameters) &mdash; Return this object&#039;s parameters instance.
- [`setParameters()`](#setParameters) &mdash; Set an object&#039;s parameters.

### `getParameter()` <a name="getParameter"></a>

Returns the parameter value for the given parameter key.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`string`) &mdash; key of parameter
    - `$default` (`mixed`) &mdash; value to return if parameter doesn&#039;t exist
- _Returns:_ value for that parameter or default given
    - `mixed`

### `hasParameter()` <a name="hasParameter"></a>

Returns whether the parameter exists or not.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`string`) &mdash; key to check
- _Returns:_ true, if parameter exists; false otherwise
    - `bool`

### `setParameter()` <a name="setParameter"></a>

Sets a given value for the specified parameter.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`string`) &mdash; key of the parameter
    - `$value` (`mixed`) &mdash; value to set for the given parameter key
    - `$replace` (`bool`) &mdash; whether or not to replace values of existing keys
- _Returns:_ the value set
    - `mixed`

### `removeParameter()` <a name="removeParameter"></a>

Removes the given parameter.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`string`) &mdash; name of key to remove
- _Returns:_ value of the removed key
    - `mixed`
    - `null`

### `clearParameters()` <a name="clearParameters"></a>

Delete all parameters.

#### Signature

- It is a **public** method.
- It does not return anything.

### `addParameters()` <a name="addParameters"></a>

Adds the given parameters to the current ones.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$data` (`array`) &mdash; array of key-value pairs or ArrayAccess implementing object
    - `$replace` (`bool`) &mdash; whether or not to replace values of existing keys
- _Returns:_ instance for fluent API
    - [`ParametersTrait`](../Params/ParametersTrait.md)
- It throws one of the following exceptions:
    - [`InvalidArgumentException`](http://php.net/class.InvalidArgumentException) &mdash; on invalid data type given

### `getParameterKeys()` <a name="getParameterKeys"></a>

Returns all the first level key names.

#### Signature

- It is a **public** method.
- _Returns:_ of parameter keys
    - `array`

### `searchParameters()` <a name="searchParameters"></a>

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

### `getParametersAsArray()` <a name="getParametersAsArray"></a>

Returns the parameters data as an associative array.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$recursive` (`bool`) &mdash; whether or not nested arrays should be included as array or object
- _Returns:_ with all data
    - `array`

### `getParameters()` <a name="getParameters"></a>

Return this object&#039;s parameters instance.

#### Signature

- It is a **public** method.
- _Returns:_ instance used internally
    - [`Parameters`](../Params/Parameters.md)

### `setParameters()` <a name="setParameters"></a>

Set an object&#039;s parameters.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$parameters` (`mixed`) &mdash; Either array or ArrayAccess implementing object.
- It does not return anything.

