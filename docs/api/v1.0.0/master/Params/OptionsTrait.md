<small>Params</small>

OptionsTrait
============

Trait that contains a Parameters instance to use for nestable configuration options.

Signature
---------

- It is a(n) **class**.

Methods
-------

The class defines the following methods:

- [`getOption()`](#getOption) &mdash; Returns the option value for the given option key.
- [`hasOption()`](#hasOption) &mdash; Returns whether the option exists or not.
- [`setOption()`](#setOption) &mdash; Sets a given value for the specified option.
- [`removeOption()`](#removeOption) &mdash; Removes the given option.
- [`clearOptions()`](#clearOptions) &mdash; Delete all options.
- [`addOptions()`](#addOptions) &mdash; Adds the given options to the current ones.
- [`getOptionKeys()`](#getOptionKeys) &mdash; Returns all the first level key names.
- [`searchOptions()`](#searchOptions) &mdash; Allows to search for specific options via JMESPath expressions.
- [`getOptionsAsArray()`](#getOptionsAsArray) &mdash; Returns the options data as an associative array.
- [`getOptions()`](#getOptions) &mdash; Return this object&#039;s options instance.
- [`setOptions()`](#setOptions) &mdash; Set an object&#039;s options.

### `getOption()` <a name="getOption"></a>

Returns the option value for the given option key.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`string`) &mdash; key of option
    - `$default` (`mixed`) &mdash; value to return if option doesn&#039;t exist
- _Returns:_ value for that option or default given
    - `mixed`

### `hasOption()` <a name="hasOption"></a>

Returns whether the option exists or not.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`string`) &mdash; key of the option to check
- _Returns:_ true, if option exists; false otherwise
    - `bool`

### `setOption()` <a name="setOption"></a>

Sets a given value for the specified option.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`string`) &mdash; key of the option
    - `$value` (`mixed`) &mdash; value to set for the given option name
    - `$replace` (`bool`) &mdash; whether or not to replace values of existing keys
- _Returns:_ the value set
    - `mixed`

### `removeOption()` <a name="removeOption"></a>

Removes the given option.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`string`) &mdash; name of key to remove
- _Returns:_ value of the removed key
    - `mixed`
    - `null`

### `clearOptions()` <a name="clearOptions"></a>

Delete all options.

#### Signature

- It is a **public** method.
- It does not return anything.

### `addOptions()` <a name="addOptions"></a>

Adds the given options to the current ones.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$data` (`array`) &mdash; array of key-value pairs or ArrayAccess implementing object
    - `$replace` (`bool`) &mdash; whether or not to replace values of existing keys
- _Returns:_ instance for fluent API
    - [`OptionsTrait`](../Params/OptionsTrait.md)
- It throws one of the following exceptions:
    - [`InvalidArgumentException`](http://php.net/class.InvalidArgumentException) &mdash; on invalid data type given

### `getOptionKeys()` <a name="getOptionKeys"></a>

Returns all the first level key names.

#### Signature

- It is a **public** method.
- _Returns:_ of option keys
    - `array`

### `searchOptions()` <a name="searchOptions"></a>

Allows to search for specific options via JMESPath expressions.

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

### `getOptionsAsArray()` <a name="getOptionsAsArray"></a>

Returns the options data as an associative array.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$recursive` (`bool`) &mdash; whether or not nested arrays should be included as array or object
- _Returns:_ with all data
    - `array`

### `getOptions()` <a name="getOptions"></a>

Return this object&#039;s options instance.

#### Signature

- It is a **public** method.
- _Returns:_ instance used internally
    - [`Parameters`](../Params/Parameters.md)

### `setOptions()` <a name="setOptions"></a>

Set an object&#039;s options.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$options` (`mixed`) &mdash; Either &#039;Parameters&#039; instance or array suitable for creating one.
- It does not return anything.

