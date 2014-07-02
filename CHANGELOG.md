# Changelog

All new features, changes and fixes should be listed here. Please use tickets to reference changes.

## 2.0.0 (2014/07/03)

BREAKING CHANGES. You can now have `Parameters` or `Options` in a mutable or
immutable variant depending on your needs. To use the functionality you can use
traits or extend the base classes. Interfaces have been added as well.

* [add] `ImmutableParameters`, `ImmutableParametersTrait`,
  `ImmutableParametersInterface`
* [add] `ImmutableOptions`, `ImmutableOptionsTrait`,
  `ImmutableOptionsInterface`
* [chg] multiple changes to method names (`map` instead of `each`, `getValues`
  instead of `search` etc.)
* [fix] some smaller API doc fixes for consistency

## 1.2.0 (2014/07/02)

* [fix] Documentation of some methods was misleading. Return values for fluent
  API support within the traits have been adjusted. The `clear` method and it's
  counterparts in the traits now support fluent API as well.

## 1.1.0 (2014/07/01)

* [add] `ParametersTrait` that works like the `OptionsTrait`, but wraps
  parameters instead of options and thus has `getParameter` etc. methods. See
  issue #9.

## 1.0.1 (2014/07/01)

* [fix] JsonSerializable test failed on Travis-CI due to PHP inconsistencies.

## 1.0.0 (2014/07/01)

The `Parameters` class now extends `ArrayObject`. That means, in addtion to
`ArrayAccess` it implements `Serializable`, `Countable` and `IteratorAggregate`.

* [add] BREAKING CHANGE! `Parameters` now extends `ArrayObject` and gets all the
  methods that are coming with that change. See issue #7.
* [add] BREAKING CHANGE! Nested arrays are now `Parameters` objects instead of
  arrays to support recursive getting and modification of values. See issue #4.
* [add] `getArrayCopy`, `__clone` and `toArray` work recursively (deep clone)
* [add] ```each($callback)``` method that gets each key of the current level
  with it's key and must return the new value to set for the key. See issue #5.
* [add] ```$replace``` argument for `add()` and `set()` methods to be able to
  prevent overwriting of values for already existing keys. See issue #3.
* [add] `OptionsTrait` that can be mixed into existing classes to get an
  internal options object with methods like `addOption`, `getOption` etc. Not
  all methods of `Parameters` are proxied, but a `getOptions` method exists that
  allows access to the internal options object. If you want to prevent that,
  change the visibility of the method to `protected` in the using class. See
  issue #8.
* [add] `Parameters` now implements `JsonSerializable` as well.
* [fix] The internal Makefile target `folders` was slightly broken.

## 0.2.0 (2014/06/29)

* [add] Markdown [API docs](docs/api/) via `sami` and a `sami-github` theme
* [add] Scrutinizer configuration for continuous integration improvements

## 0.1.0 (2014/06/28)

* [add] ```search($expression)``` method to get multiple values at once or retrieve nested values via [JMESPath expressions](http://jmespath.readthedocs.org/en/latest/index.html) (#2)
* [add] Parameters array wrapper class with conveninient `get($key, $default)` that implements `\ArrayAccess` (#1)
* [fix] none
* [chg] none
