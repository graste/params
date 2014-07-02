# Params

[![Latest-Stable-Version](https://poser.pugx.org/graste/params/v/stable.svg)][1]
[![License](https://poser.pugx.org/graste/params/license.svg)][14]
[![Latest Unstable Version](https://poser.pugx.org/graste/params/v/unstable.svg)][1]
[![Build Status](https://secure.travis-ci.org/graste/params.png)][2]
[![Coverage Status](https://coveralls.io/repos/graste/params/badge.png)][3]
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/graste/params/badges/quality-score.png?b=master)][5]
[![Dependency Status](https://www.versioneye.com/user/projects/53aefa3b404aa6df8c000082/badge.svg)][4]
[![Stories in Ready](https://badge.waffle.io/graste/params.png?label=ready&title=Ready)](https://waffle.io/graste/params)
[![Total Composer Downloads](https://poser.pugx.org/graste/params/d/total.png)][1]

## Purpose

Array wrapper object that eases the retrieval of values. It provides a `get`
method that can return a default value if the given key is missing. In addition
to the usage as a normal array and the various `get`, `set`, `has` etc. methods
Parameters defines a `search($expression)` method that allows the retrieval of
values by providing more or less complex expressions. You can easily retrieve
values from nested arrays or get several values from different nesting levels
with one call. There are traits for convenient creation of configurable classes.

## Requirements and installation

- PHP v5.4+

Install the library via [Composer][10]:

```./composer.phar require graste/params [optional version]```

Adding it manually as a vendor library requirement to the `composer.json` file
of your project works as well:

```json
{
    "require": {
        "graste/params": "~1.2"
    }
}
```

Alternatively, you can download a release archive from the [releases][9].

## Documentation and usage

```php
$data = array(
    'str' => 'some string',
    'first_level' => 'first level',
    'nested' => array(
        'str' => 'some nested string',
        '2nd level' => 'second level',
    ),
    'more' => array(
        'str' => 'other nested string',
    )
);

$params = new \Params\Parameters($data);

// use it as a recursive object:

$params->get("str")                             // gives "some string"
$params->get("nested")                          // gives array stored under "nested" key
$params->get("nested")->get('str')              // gives "some nested string"
$params->get("non-existant", "default value")   // gives "default value" as given key is non existant
$params->set("foo", "bar")                      // sets key "foo" to value "bar"
$params->get("nested")->set("foo", "bar")       // sets key "foo" to value "bar" on the "nested" array
$params->add(array|ArrayAccess)                 // add array or other ArrayAccess implementing object to current instance
$params->has("foo")                             // returns true now
$params->getKeys()                              // returns all first level keys
$params->toArray()                              // returns internal array
$params->clear()                                // empty internal array
$params->each(function($key, $value) { … })     // modifies each value to the value returned by the callback

// retrieve values using expressions

$params->search("foo")                                  // gives "bar"
$params->search("nested.str")                           // gives "some nested string"
$params->search('*.str')                                // gives array("some nested string", "other nested string")
$params->search('[str, nested.str]')                    // gives array("some string", "some nested string")
$params->search('nested."2nd level" || first_level')    // gives "second level" as that key exists; other expression not evaluated
$params->search('first_level || nested."2nd level"')    // gives "first level" as that key exists; other expression not evaluated

// use it as an array:

$params["str"]      // gives "some string"
$params["nested"]   // gives the array under the "nested" key
$params[1]          // gives "first level"

// use it as an object with properties

$params->foo = 'bar'            // sets key 'foo' to value 'bar'
$params->filter->bool = 'yes'   // sets $params['filter']['bool'] to value 'yes'
```

The expression syntax used is provided by Michael Dowling's [JMESPath][11].

## Traits

There are two traits that wrap `Parameters` instances for your classes that
need to be configurable:

- `ParametersTrait` wraps `parameters`
- `OptionsTrait` wraps `options`

For fluent API support the methods `add`, `set`, `set(Options|Parameters)` and
`clear(Options|Parameters)` return the class instance they're mixed into.

## ElasticSearch queries

The syntax sugar `Parameters` gives you is not only nice to define configurable
classes, but also ease the creation and modification of ElasticSearch queries:

```php
$params->filter->bool->must[1]->term->live = false;
$params->get('filter')->set('bool', …);
$params->filter->bool->must[] = array(…);
```

## Community

None, but you may join the `#environaut` freenode IRC channel anytime
([`irc://irc.freenode.org/environaut`](irc://irc.freenode.org/environaut)) :-)

## Contribution

Please contribute by [forking][12] and sending a [pull request][13]. More
information can be found in the [`CONTRIBUTING.md`](CONTRIBUTING.md) file.

To develop on this repository clone your fork and use the `Makefile` targets:

- `make install` installs composer and all necessary vendor libraries
- `make tests` runs the phpunit tests
- `make code-sniffer` runs the code sniffer

The code trys to adhere to the following PHP-FIG standards: [PSR-0][6],
[PSR-1][7] and [PSR-2][8]

## Changelog

See [`CHANGELOG.md`](CHANGELOG.md) for more information about changes.


[1]: https://packagist.org/packages/graste/params "graste/params on packagist"
[2]: http://travis-ci.org/graste/params "graste/params on travis-ci"
[3]: https://coveralls.io/r/graste/params "graste/params on coveralls"
[4]: https://www.versioneye.com/user/projects/53aefa3b404aa6df8c000082 "graste/params on versioneye"
[5]: https://scrutinizer-ci.com/g/graste/params/?branch=master "graste/params on scrutinizer-ci"
[6]: http://www.php-fig.org/psr/psr-0/ "PSR-0 Autoloading Standard"
[7]: http://www.php-fig.org/psr/psr-1/ "PSR-1 Basic Coding Standard"
[8]: http://www.php-fig.org/psr/psr-2/ "PSR-2 Coding Style Guide"
[9]: https://github.com/graste/params/releases "graste/params releases on github"
[10]: https://getcomposer.org/ "Composer homepage with further documentation"
[11]: https://github.com/mtdowling/jmespath.php "JMESPath on github"
[12]: http://help.github.com/forking/ "Github docs on forking a project"
[13]: http://help.github.com/pull-requests/ "Github docs on pull requests"
[14]: LICENSE.md "license file with link to original full text of the license"
[15]: https://waffle.io/graste/params "graste/params on waffle"
