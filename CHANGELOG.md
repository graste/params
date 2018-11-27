# Changelog

All new features, changes and fixes should be listed here. Please use tickets to reference changes.

## 3.1.0 (2018/11/27)

- [chg] bump dependencies of libraries and allow PHP version ^5.6 or ^7.0
- [chg] travisci now tests PHP versions 5.6, 7.0, 7.1 and 7.2 (an still nightly and hhvm)
- [del] removed support to generate docs via sami (as it's abandoned and I'm not in the mood to search a replacement)
- [del] scrutinizer support for codequality etc. has been removed (was used in CI and local dev)
- [fix] phpunit configuration used a nonexistant directory in the filter whitelist

## 3.0.0 (2015/03/08)

This release may be a breaking change for people that used `instanceof` checks
or set a different default iterator for the `ArrayObject` class. For People
using the classes or traits as-is nothing should change. The tests were not
modified at all. There may be not enough or they may be badly written though.
That's why this release version gets a major +1.

There's now a common base class `ConfigurableArrayObject` that takes an array
with options that may modify the behaviour of that class. First option is
`mutable` to define whether the object should prevent modifications of the
internal data set via the constructor. The second known option is `iterator`.
That option takes a fully qualified class name to set the default iterator
being used. Future releases may see additional options.

* [chg] License changed to [MIT](LICENSE.md) (#14)
* [chg] Refactoring and change in structure of inheritance/interfaces (#13)
* [add] `ConfigurableArrayObject` as base class for all variants (#13)
* [add] `SettingsMutableInterface`, `ParametersMutableInterface`, `OptionsMutableInterface` (#13)
* [add] `ParamsInterface` and `ParamsMutableInterface` to use for the others as a base (#13)
* [chg] Autoloading in composer.json now uses PSR-4 instead of PSR-0.
* [chg] Updated composer dependencies in lock file (only dev libs should be affected)

## 2.1.1 (2015/28/07)

* [chg] Updated composer.json to allow for newer jmespath.php versions

## 2.1.0 (2014/10/07)

* [add] `Settings`, `SettingsTrait`, `SettingsInterface`
* [add] `ImmutableSettings`, `ImmutableSettingsTrait`, `ImmutableSettingsInterface`

## 2.0.1 (2014/10/06)

Updated composer dependencies for:

* jmespath.php
* phpunit
* php-codesniffer
* sami

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
