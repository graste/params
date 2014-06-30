# Changelog

All new features, changes and fixes should be listed here. Please use tickets to reference changes.

## 1.0.0 (2014/xx/xx)

The `Parameters` class now extends `ArrayObject`. Instead of only implementing
`ArrayAccess` it now implements `Serializable`, `Countable` and `IteratorAggregate`.

* [add] BREAKING CHANGE! Nested arrays are now `Parameters` objects instead of
  arrays to support recursive getting and modification of values.
* [add] BREAKING CHANGE! `Parameters` now extends `ArrayObject`
* [add] `getArrayCopy`, `__clone` and `toArray` work recursively (deep clone)

## 0.2.0 (2014/06/29)

* [add] Markdown [API docs](docs/api/) via `sami` and a `sami-github` theme
* [add] Scrutinizer configuration for continuous integration improvements

## 0.1.0 (2014/06/28)

* [add] ```search($expression)``` method to get multiple values at once or retrieve nested values via [JMESPath expressions](http://jmespath.readthedocs.org/en/latest/index.html) (#2)
* [add] Parameters array wrapper class with conveninient `get($key, $default)` that implements `\ArrayAccess` (#1)
* [fix] none
* [chg] none
