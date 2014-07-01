<?php

namespace Params\Tests;

use Params\Parameters;

class OptionsTraitTest extends BaseTestCase
{
    public function testConstruct()
    {
        $p = new OptionsTraitTester();

        $this->assertEquals(0, count($p->getOptionsAsArray()));
        $this->assertEmpty($p->getOptionKeys());
    }

    public function testCreate()
    {
        $data = $this->getExampleValues();
        $params = new OptionsTraitTester();
        $params->setOptions($data);

        $this->assertInstanceOf('\\Params\\Parameters', $params->getOptions());
        $this->assertEquals($data['str'], $params->getOption('str'));
        $this->assertEquals($data['int'], $params->getOption('int'));
        $this->assertEquals($data['bool'], $params->getOption('bool'));
    }

    public function testgetOptionsAsArray()
    {
        $data = $this->getExampleValues();
        $params = new OptionsTraitTester();
        $params->setOptions($data);

        $this->assertEquals($data, $params->getOptionsAsArray());
    }

    public function testGetDefaultValues()
    {
        $params = new OptionsTraitTester();
        $params->setOptions(
            new Parameters(
                array(
                    'nil' => null,
                    'null_as_string' => '0',
                    'null_as_int' => 0
                )
            )
        );

        $this->assertEquals('default', $params->getOption('non_existant', 'default'));
        $this->assertFalse($params->hasOption('non_existant'));

        $this->assertEquals(null, $params->getOption('nil', 'default'));
        $this->assertTrue($params->hasOption('nil'));
        $this->assertFalse($params->hasOption('NIL'));

        $this->assertEquals('0', $params->getOption('null_as_string', 'default'));
        $this->assertTrue($params->hasOption('null_as_string'));
        $this->assertFalse($params->hasOption('Null_as_string'));

        $this->assertEquals(0, $params->getOption('null_as_int', 'default'));
        $this->assertTrue($params->hasOption('null_as_int'));
        $this->assertFalse($params->hasOption('Null_as_int'));
    }

    public function testSetValue()
    {
        $params = new OptionsTraitTester();
        $params->setOptions(array('foo' => 'trololo'));
        $params->setOption('foo', 'bar');
        $params->setOption('nil', null);

        $this->assertEquals('bar', $params->getOption('foo', 'default'));
        $this->assertEquals(null, $params->getOption('nil', 'default'));
    }

    public function testSet()
    {
        $params = new OptionsTraitTester();
        $params->getOptions()['foo'] = 'bar';
        $params->getOptions()->blah = 'blub';
        $this->assertEquals('bar', $params->getOptions()->foo);
        $this->assertEquals('blub', $params->getOptions()['blah']);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetEmptyKeyFails()
    {
        $params = new OptionsTraitTester();
        $params->setOptions(array('foo' => 'trololo'));
        $params->setOption('', 'bar');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetNullKeyFails()
    {
        $params = new OptionsTraitTester();
        $params->setOptions(array('foo' => 'trololo'));
        $params->setOption(null, 'bar');
    }

    public function testSetDoesntReplace()
    {
        $params = new OptionsTraitTester();
        $params->setOptions(array('foo' => 'bar'));
        $params->setOption('foo', 'omg', false);
        $this->assertEquals('bar', $params->getOption('foo'));
        $params->setOption('foo', 'omg', true);
        $this->assertEquals('omg', $params->getOption('foo'));
    }

    public function testAddDoesntReplace()
    {
        $params = new OptionsTraitTester();
        $params->setOptions(array('foo' => 'bar'));
        $params->addOptions(array('foo' => 'omg'), false);
        $this->assertEquals('bar', $params->getOption('foo'));
        $params->addOptions(array('foo' => 'omg'), true);
        $this->assertEquals('omg', $params->getOption('foo'));
    }

    public function testSetParametersAsOptions()
    {
        $params = new OptionsTraitTester();
        $params->setOptions(new Parameters(array('foo' => 'bar')));

        $this->assertEquals('bar', $params->getOption('foo'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetInvalidOptionsFails()
    {
        $params = new OptionsTraitTester();
        $params->setOptions('trololo');
    }

    public function testFluentApi()
    {
        $params = new OptionsTraitTester();
        $params->setOptions(array('foo' => 'trololo'));

        $this->assertInstanceOf('Params\Parameters', $params->setOption('fluent', 'yes'));
        $this->assertInstanceOf('Params\Parameters', $params->addOptions(array('api' => 'stuff')));
    }

    public function testGetKeys()
    {
        $params = new OptionsTraitTester();
        $params->setOptions(array('foo' => 'trololo'));
        $params->setOption('foo', 'bar');
        $params->setOption('nil', null);

        $this->assertEquals(array('foo', 'nil'), $params->getOptionKeys());
    }

    public function testClearValues()
    {
        $params = new OptionsTraitTester();
        $params->setOptions(array('foo' => 'trololo'));
        $params->clearOptions();

        $this->assertEquals(array(), $params->getOptionsAsArray());
    }

    public function testRemove()
    {
        $params = new OptionsTraitTester();
        $params->setOptions(array('foo' => 'bar'));
        $foo = $params->removeOption('foo');
        $this->assertFalse($params->hasOption('foo'));
        $this->assertEquals('bar', $foo);
    }

    public function testAddArray()
    {
        $params = new OptionsTraitTester();
        $params->setOptions(array('foo' => 'bar'));
        $new = array('foo' => 'omg', 'blah' => 'blub');
        $params->addOptions($new);
        $this->assertEquals(
            array(
                'foo' => 'omg',
                'blah' => 'blub'
            ),
            $params->getOptionsAsArray()
        );
    }

    public function testAddParameters()
    {
        $params = new OptionsTraitTester();
        $params->setOptions(array('foo' => 'bar'));
        $new_params = new Parameters(array('foo' => 'omg', 'blah' => 'blub'));
        $params->addOptions($new_params);
        $this->assertEquals(
            array(
                'foo' => 'omg',
                'blah' => 'blub'
            ),
            $params->getOptionsAsArray()
        );
    }

    public function testTypeChangeAndAddOnDeeperLevel()
    {
        $params = new OptionsTraitTester();
        $params->setOptions($this->getExampleValues());
        $new = array('foo' => 'omg', 'blah' => 'blub');
        $params->getOption('nested')->set('bool', $new)->add($new);
        $this->assertEquals($new, $params->getOption('nested')->get('bool')->toArray());
        $this->assertEquals($new, $params->searchOptions('nested.bool'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddInvalidType()
    {
        $params = new OptionsTraitTester();
        $params->setOptions(array('foo' => 'bar'));
        $params->addOptions(new \StdClass());
    }

    public function testSearchOrExpression()
    {
        $params = new OptionsTraitTester();
        $params->setOptions($this->getExampleValues());
        $this->assertEquals('second level', $params->searchOptions('nested."2nd level" || first_level'));
        $this->assertEquals('first level', $params->searchOptions('first_level || nested."2nd level"'));
    }

    public function testRecursiveGet()
    {
        $params = new OptionsTraitTester();
        $params->setOptions($this->getExampleValues());
        $this->assertEquals('second level', $params->getOption('nested')->get("2nd level"));
    }

    public function testDeepArrayModification()
    {
        $params = new OptionsTraitTester();
        $params->setOptions($this->getExampleValues());
        $params->getOption('nested')->add(array('omg' => 'yes'));
        $this->assertEquals('yes', $params->getOption('nested')->get('omg'));
        $this->assertEquals('yes', $params->searchOptions('nested.omg'));
    }

    protected function getExampleValues()
    {
        return array(
            'str' => 'some string',
            'int' => mt_rand(0, 999),
            'bool' => (mt_rand(1, 100) <= 50) ? true : false,
            'first_level' => 'first level',
            'nested' => array(
                'str' => 'some nested string',
                'int' => mt_rand(10000, 19999),
                'bool' => (mt_rand(1, 100) <= 50) ? true : false,
                '2nd level' => 'second level',
            ),
            'more' => array(
                'str' => 'other nested string'
            )
        );
    }
}

