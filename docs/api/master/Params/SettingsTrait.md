<small>Params</small>

SettingsTrait
=============

Trait that contains a Settings instance to use for nestable configuration settings.

Signature
---------

- It is a(n) **class**.

Methods
-------

The class defines the following methods:

- [`setSetting()`](#setSetting) &mdash; Sets a given value for the specified key.
- [`addSettings()`](#addSettings) &mdash; Adds the given data (key/value pairs) to the current data.
- [`removeSetting()`](#removeSetting) &mdash; Removes the given key from the internal array.
- [`clearSettings()`](#clearSettings) &mdash; Delete all internal data.
- [`setSettings()`](#setSettings) &mdash; Set an object&#039;s settings.

### `setSetting()` <a name="setSetting"></a>

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

### `addSettings()` <a name="addSettings"></a>

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

### `removeSetting()` <a name="removeSetting"></a>

Removes the given key from the internal array.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$key` (`mixed`) &mdash; name of key to remove
- _Returns:_ self instance for fluent API
    - [`Settings`](../Params/Settings.md)

### `clearSettings()` <a name="clearSettings"></a>

Delete all internal data.

#### Signature

- It is a **public** method.
- _Returns:_ self instance for fluent API
    - [`Settings`](../Params/Settings.md)

### `setSettings()` <a name="setSettings"></a>

Set an object&#039;s settings.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$settings` (`mixed`) &mdash; Either array or ArrayAccess implementing object.
- It does not return anything.
- It throws one of the following exceptions:
    - [`InvalidArgumentException`](http://php.net/class.InvalidArgumentException) &mdash; on wrong data type given

