# Params

* Latest Version: [![Latest Stable Version](https://poser.pugx.org/graste/params/version.png)](https://packagist.org/packages/graste/params)
* Build: [![Build Status](https://secure.travis-ci.org/graste/params.png)](http://travis-ci.org/graste/params)
* Coverage: [![Coverage Status](https://coveralls.io/repos/graste/params/badge.png)](https://coveralls.io/r/graste/params)
* Code: [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/graste/params/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/graste/params/?branch=master)

Please have a look at the [available releases](https://github.com/graste/params/releases).

## Purpose

Simple wrapper around arrays to ease the handling of parameters or options. It
eases getting values with default values when keys don't exists and allows you
to retrieve nested or multiple values at once via search expressions.

## Requirements and installation

- PHP v5.4+

Install the library via [Composer](https://getcomposer.org/):

```./composer.phar require graste/params [optional version]```

Adding it manually as a vendor library requirement to the `composer.json` file
of your project works as well:

```json
{
    "require": {
        "graste/params": "~0.1"
    }
}
```

Alternatively, you can download a release archive from the [github releases](releases).

## Documentation

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

// use it as an object:

$params->get("str")                             // gives "some string"
$params->get("nested")                          // gives array stored under "nested" key
$params->get("non-existant", "default value")   // gives "default value" as given key is non existant
$params->set("foo", "bar")                      // sets key "foo" to value "bar"
$params->add(array|Parameters)                  // add array or other Parameters to current instance
$params->has("foo")                             // returns true now
$params->getKeys() or $params->keys()           // returns all first level keys
$params->toArray()                              // returns internal array
$params->clear()                                // empty internal array

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
```

The expression syntax used is provided by Michael Dowling's [JMESPath](https://github.com/mtdowling/jmespath.php).

## Community

None, but you may join the `#environaut` freenode IRC channel anytime
([`irc://irc.freenode.org/environaut`](irc://irc.freenode.org/environaut)) :-)

## Contributors

Please contribute by [forking](http://help.github.com/forking/) and sending a
[pull request](http://help.github.com/pull-requests/). More information can be
found in the [`CONTRIBUTING.md`](CONTRIBUTING.md) file.

## Changelog

See [`CHANGELOG.md`](CHANGELOG.md) for more information about changes.

* Total Composer Downloads: [![Composer Downloads](https://poser.pugx.org/graste/params/d/total.png)](https://packagist.org/packages/graste/params)
