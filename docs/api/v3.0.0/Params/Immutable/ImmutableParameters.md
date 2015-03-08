<small>Params\Immutable</small>

ImmutableParameters
===================

Class that gives recursive read-only access to parameters added via constructor.

Signature
---------

- It is a(n) **class**.
- It implements the [`ImmutableParametersInterface`](../../Params/Immutable/ImmutableParametersInterface.md) interface.
- It is a subclass of [`ConfigurableArrayObject`](../../Params/ConfigurableArrayObject.md).

Methods
-------

The class defines the following methods:

- [`__construct()`](#__construct) &mdash; Create a new instance with the given data as initial value set.

### `__construct()` <a name="__construct"></a>

Create a new instance with the given data as initial value set.

#### Description

The &#039;mutable&#039; option will be set to false even if provided as true.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$data` (`array`) &mdash; initial data
    - `$options` (`array`)
- It does not return anything.

