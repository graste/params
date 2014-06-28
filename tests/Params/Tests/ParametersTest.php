<?php

namespace Params\Tests;

use Params\Parameters;

class ParametersTest extends BaseTestCase
{
    public function testConstruct()
    {
        $p = new Parameters();

        $this->assertEquals(0, count($p->toArray()));
        $this->assertEmpty($p->getKeys());
    }

    public function testCreate()
    {
        $data = $this->getExampleValues();
        $params = new Parameters($data);

        $this->assertInstanceOf('\\Params\\Parameters', $params);
        $this->assertEquals($data['str'], $params->get('str'));
        $this->assertEquals($data['int'], $params->get('int'));
        $this->assertEquals($data['bool'], $params->get('bool'));
    }

    public function testToArray()
    {
        $data = $this->getExampleValues();
        $params = new Parameters($data);

        $this->assertEquals($data, $params->toArray());
    }

    public function testGetDefaultValues()
    {
        $params = new Parameters(
            array(
                'nil' => null,
                'null_as_string' => '0',
                'null_as_int' => 0
            )
        );

        $this->assertEquals('default', $params->get('non_existant', 'default'));
        $this->assertFalse($params->has('non_existant'));

        $this->assertEquals(null, $params->get('nil', 'default'));
        $this->assertTrue($params->has('nil'));
        $this->assertFalse($params->has('NIL'));

        $this->assertEquals('0', $params->get('null_as_string', 'default'));
        $this->assertTrue($params->has('null_as_string'));
        $this->assertFalse($params->has('Null_as_string'));

        $this->assertEquals(0, $params->get('null_as_int', 'default'));
        $this->assertTrue($params->has('null_as_int'));
        $this->assertFalse($params->has('Null_as_int'));
    }

    public function testSetValue()
    {
        $params = new Parameters(array('foo' => 'trololo'));
        $params->set('foo', 'bar');
        $params->set('nil', null);

        $this->assertEquals('bar', $params->get('foo', 'default'));
        $this->assertEquals(null, $params->get('nil', 'default'));
    }

    public function testGetKeys()
    {
        $params = new Parameters(array('foo' => 'trololo'));
        $params->set('foo', 'bar');
        $params->set('nil', null);

        $this->assertEquals(array('foo', 'nil'), $params->getKeys());
    }

    public function testClearValues()
    {
        $params = new Parameters(array('foo' => 'bar'));
        $params->clear();

        $this->assertEquals(array(), $params->toArray());
    }

    public function testArrayAccessGet()
    {
        $params = new Parameters(array('foo' => 'bar'));
        $this->assertEquals('bar', $params['foo']);
        $this->assertEquals(array('foo' => 'bar'), $params->toArray());
    }

    public function testArrayAccessSet()
    {
        $params = new Parameters(array('foo' => 'bar'));
        $params['key'] = 'trololo';

        $this->assertEquals('trololo', $params['key']);
        $this->assertEquals('trololo', $params->get('key'));
        $this->assertTrue($params->has('key'));
        $this->assertEquals(array('foo', 'key'), $params->keys());
        $this->assertEquals(array('foo', 'key'), $params->getKeys());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testArrayAccessGetNonExistantThrowsException()
    {
        $params = new Parameters();
        $params['non-existant'];
    }

    public function testAddArray()
    {
        $params = new Parameters(array('foo' => 'bar'));
        $new = array('foo' => 'omg', 'blah' => 'blub');
        $params->add($new);
        $this->assertEquals(
            array(
                'foo' => 'omg',
                'blah' => 'blub'
            ),
            $params->toArray()
        );
    }

    public function testAddParameters()
    {
        $params = new Parameters(array('foo' => 'bar'));
        $new_params = new Parameters(array('foo' => 'omg', 'blah' => 'blub'));
        $params->add($new_params);
        $this->assertEquals(
            array(
                'foo' => 'omg',
                'blah' => 'blub'
            ),
            $params->toArray()
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddInvalidType()
    {
        $params = new Parameters(array('foo' => 'bar'));
        $params->add(new \StdClass());
    }

    protected function getExampleValues()
    {
        return array(
            'str' => 'some string',
            'int' => mt_rand(0, 999),
            'bool' => (mt_rand(1, 100) <= 50) ? true : false,
            'nested' => array(
                'str' => 'some nested string',
                'int' => mt_rand(10000, 19999),
                'bool' => (mt_rand(1, 100) <= 50) ? true : false,
            )
        );
    }
}

