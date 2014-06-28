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

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetEmptyKeyFails()
    {
        $params = new Parameters(array('foo' => 'trololo'));
        $params->set('', 'bar');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetNullKeyFails()
    {
        $params = new Parameters(array('foo' => 'trololo'));
        $params->set(null, 'bar');
    }

    public function testFluentApi()
    {
        $params = new Parameters(array('foo' => 'trololo'));

        $this->assertInstanceOf('Params\Parameters', $params->set('fluent', 'yes'));
        $this->assertInstanceOf('Params\Parameters', $params->add(array('api' => 'stuff')));
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

    public function testArrayAccessExists()
    {
        $params = new Parameters(array('foo' => 'bar'));
        $this->assertTrue(isset($params['foo']));
    }

    public function testArrayAccessUnset()
    {
        $params = new Parameters(array('foo' => 'bar'));
        unset($params['foo']);
        $this->assertFalse(isset($params['foo']));
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

    public function testSearchDefaultExpression()
    {
        $data = $this->getExampleValues();
        $params = new Parameters($data);
        $result = $params->search();
        $this->assertEquals($data['str'], $result[0]);
    }

    public function testSearchSimple()
    {
        $params = new Parameters($this->getExampleValues());
        $this->assertEquals('some string', $params->search('str'));
        $this->assertEquals('some nested string', $params->search('nested.str'));
        $this->assertEquals('second level', $params->search('nested."2nd level"'));
    }

    public function testSearchWildcardExpressions()
    {
        $data = $this->getExampleValues();
        $nested_count = count($data['nested']);
        $params = new Parameters($data);
        $this->assertEquals(
            array(
               'some nested string',
               'other nested string'
            ),
            $params->search('*.str')
        );

        $result = $params->search('nested.*');
        $this->assertTrue(is_array($result));
        $this->assertCount($nested_count, $result);
        $this->assertEquals('some nested string', $result[0]);
        $this->assertContains('second level', $result);
    }

    public function testSearchMultiSelectListExpression()
    {
        $data = $this->getExampleValues();
        $params = new Parameters($data);

        $result = $params->search('[str, nested.str]');
        $this->assertTrue(is_array($result));
        $this->assertCount(2, $result);
        $this->assertEquals('some string', $result[0]);
        $this->assertEquals('some nested string', $result[1]);
    }

    public function testSearchOrExpression()
    {
        $params = new Parameters($this->getExampleValues());
        $this->assertEquals('second level', $params->search('nested."2nd level" || first_level'));
        $this->assertEquals('first level', $params->search('first_level || nested."2nd level"'));
    }

    /**
     * @expectedException \JmesPath\SyntaxErrorException
     */
    public function testSearchSyntaxErrorException()
    {
        $data = $this->getExampleValues();
        $params = new Parameters($data);

        $result = $params->search('[str, nested.str'); // missing closing ]
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

