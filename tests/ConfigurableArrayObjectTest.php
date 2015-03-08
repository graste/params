<?php

namespace Params\Tests;

use Params\ConfigurableArrayObject;

class ConfigurableArrayObjectTest extends BaseTestCase
{
    public function testConstruct()
    {
        $p = new ConfigurableArrayObject();

        $this->assertEquals(0, count($p->toArray()));
        $this->assertEquals(0, $p->count());
        $this->assertEmpty($p->getKeys());
    }

    public function testCreate()
    {
        $data = $this->getExampleValues();
        $params = new ConfigurableArrayObject($data);

        $this->assertInstanceOf('\\Params\\ConfigurableArrayObject', $params);
        $this->assertEquals($data['str'], $params->get('str'));
        $this->assertEquals($data['int'], $params->get('int'));
        $this->assertEquals($data['bool'], $params->get('bool'));
    }

    public function testCustomIteratorViaOptions()
    {
        $data = $this->getExampleValues();
        $custom_iterator_class = 'Params\\Tests\\Fixtures\\CustomArrayIterator';
        $params = new ConfigurableArrayObject($data, [
            ConfigurableArrayObject::OPTION_ITERATOR => $custom_iterator_class
        ]);

        $this->assertInstanceOf('\\Params\\ConfigurableArrayObject', $params);
        $this->assertInstanceOf($custom_iterator_class, $params->getIterator());
        $this->assertTrue($params->getIterator()->getTrue());
    }

    /**
     * @expectedException \LogicException
     */
    public function testSetValueViaArrayAccessFailsWhenImmutable()
    {
        $params = new ConfigurableArrayObject([], [ ConfigurableArrayObject::OPTION_MUTABLE => false ]);
        $params['obj'] = 'asdf';
    }

    /**
     * @expectedException \LogicException
     */
    public function testSetValueViaPropertyAccessFailsWhenImmutable()
    {
        $params = new ConfigurableArrayObject([], [ ConfigurableArrayObject::OPTION_MUTABLE => false ]);
        $params->obj = 'asdf';
    }

    /**
     * @expectedException \LogicException
     */
    public function testAppendFailsWhenImmutable()
    {
        $params = new ConfigurableArrayObject([], [ ConfigurableArrayObject::OPTION_MUTABLE => false ]);
        $params->append(array('foo' => 'omg'));
    }

    /**
     * @expectedException \LogicException
     */
    public function testUnsetFailsWhenImmutable()
    {
        $params = new ConfigurableArrayObject(
            [ 'foo' => 'bar'],
            [ ConfigurableArrayObject::OPTION_MUTABLE => false ]
        );
        unset($params['foo']);
    }

    /**
     * @expectedException \LogicException
     */
    public function testExchangeArrayFails()
    {
        $params = new ConfigurableArrayObject([], [ ConfigurableArrayObject::OPTION_MUTABLE => false ]);
        $params->exchangeArray(array('foo' => 'omg'));
    }

    public function testToArray()
    {
        $data = $this->getExampleValues();
        $params = new ConfigurableArrayObject($data);

        $this->assertEquals($data, $params->toArray());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testToArrayWithWrongObjectThrows()
    {
        $data = $this->getExampleValues();
        $params = new ConfigurableArrayObject($data);
        $params->set('obj', $this);

        $params->toArray();
    }

    public function testGetDefaultValues()
    {
        $params = new ConfigurableArrayObject(
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
        $params = new ConfigurableArrayObject(array('foo' => 'trololo'));
        $params->set('foo', 'bar');
        $params->set('nil', null);

        $this->assertEquals('bar', $params->get('foo', 'default'));
        $this->assertEquals(null, $params->get('nil', 'default'));
    }

    public function testSet()
    {
        $params = new ConfigurableArrayObject();
        $params['foo'] = 'bar';
        $params->blah = 'blub';
        $this->assertEquals('bar', $params->foo);
        $this->assertEquals('blub', $params['blah']);
    }

    public function testSetDoesntReplace()
    {
        $params = new ConfigurableArrayObject(array('foo' => 'bar'));
        $params->set('foo', 'omg', false);
        $this->assertEquals('bar', $params->foo);
        $params->set('foo', 'omg', true);
        $this->assertEquals('omg', $params->foo);
    }

    public function testAddDoesntReplace()
    {
        $params = new ConfigurableArrayObject(array('foo' => 'bar'));
        $params->add(array('foo' => 'omg'), false);
        $this->assertEquals('bar', $params->foo);
        $params->add(array('foo' => 'omg'), true);
        $this->assertEquals('omg', $params->foo);
    }

/*
    public function testAutoCreateSet()
    {
        $params = new ConfigurableArrayObject();
        //$params->meh->omg = 'yes';
        $params['one']['two'] = 'three';
        //$this->assertEquals('yes', $params->get('meh')->get('omg'));
        $this->assertEquals('three', $params->one->two);
    }
 */
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetEmptyKeyFails()
    {
        $params = new ConfigurableArrayObject(array('foo' => 'trololo'));
        $params->set('', 'bar');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetNullKeyFails()
    {
        $params = new ConfigurableArrayObject(array('foo' => 'trololo'));
        $params->set(null, 'bar');
    }

    public function testFluentApi()
    {
        $params = new ConfigurableArrayObject(array('foo' => 'trololo'));

        $this->assertInstanceOf('Params\ConfigurableArrayObject', $params->set('fluent', 'yes'));
        $this->assertInstanceOf('Params\ConfigurableArrayObject', $params->add(array('api' => 'stuff')));
    }

    public function testGetKeys()
    {
        $params = new ConfigurableArrayObject(array('foo' => 'trololo'));
        $params->set('foo', 'bar');
        $params->set('nil', null);

        $this->assertEquals(array('foo', 'nil'), $params->getKeys());
    }

    public function testClearValues()
    {
        $params = new ConfigurableArrayObject(array('foo' => 'bar'));
        $params->clear();

        $this->assertEquals(array(), $params->toArray());
    }

    public function testArrayAccessGet()
    {
        $params = new ConfigurableArrayObject(array('foo' => 'bar'));
        $this->assertEquals('bar', $params['foo']);
        $this->assertEquals(array('foo' => 'bar'), $params->toArray());
    }

    public function testArrayAccessExists()
    {
        $params = new ConfigurableArrayObject(array('foo' => 'bar'));
        $this->assertTrue(isset($params['foo']));
    }

    public function testArrayAccessUnset()
    {
        $params = new ConfigurableArrayObject(array('foo' => 'bar'));
        unset($params['foo']);
        $this->assertFalse(isset($params['foo']));
    }

    public function testArrayAccessSet()
    {
        $params = new ConfigurableArrayObject(array('foo' => 'bar'));
        $params['key'] = 'trololo';

        $this->assertEquals('trololo', $params['key']);
        $this->assertEquals('trololo', $params->get('key'));
        $this->assertTrue($params->has('key'));
        $this->assertEquals(array('foo', 'key'), $params->getKeys());
        $this->assertEquals(array('foo', 'key'), $params->getKeys());
    }

    public function testArrayAccessGetNonExistantGivesNull()
    {
        $params = new ConfigurableArrayObject();
        $this->assertNull($params['non-existant']);
    }

    public function testRemove()
    {
        $params = new ConfigurableArrayObject(array('foo' => 'bar'));
        $foo = $params->remove('foo');
        $this->assertFalse(isset($params['foo']));
        $this->assertFalse($params->has('foo'));
    }

    public function testAddArray()
    {
        $params = new ConfigurableArrayObject(array('foo' => 'bar'));
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
        $params = new ConfigurableArrayObject(array('foo' => 'bar'));
        $new_params = new ConfigurableArrayObject(array('foo' => 'omg', 'blah' => 'blub'));
        $params->add($new_params);
        $this->assertEquals(
            array(
                'foo' => 'omg',
                'blah' => 'blub'
            ),
            $params->toArray()
        );
    }

    public function testTypeChangeAndAddOnDeeperLevel()
    {
        $params = new ConfigurableArrayObject($this->getExampleValues());
        $new = array('foo' => 'omg', 'blah' => 'blub');
        $params->get('nested')->set('bool', $new)->add($new);
        $this->assertEquals($new, $params->get('nested')->get('bool')->toArray());
        $this->assertEquals($new, $params->getValues('nested.bool'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddInvalidType()
    {
        $params = new ConfigurableArrayObject(array('foo' => 'bar'));
        $params->add(new \StdClass());
    }

    public function testSearchDefaultExpression()
    {
        $data = $this->getExampleValues();
        $params = new ConfigurableArrayObject($data);
        $result = $params->getValues();
        $this->assertEquals($data['str'], $result[0]);
    }

    public function testSearchSimple()
    {
        $params = new ConfigurableArrayObject($this->getExampleValues());
        $this->assertEquals('some string', $params->getValues('str'));
        $this->assertEquals('some nested string', $params->getValues('nested.str'));
        $this->assertEquals('second level', $params->getValues('nested."2nd level"'));
    }

    public function testSearchWildcardExpressions()
    {
        $data = $this->getExampleValues();
        $nested_count = count($data['nested']);
        $params = new ConfigurableArrayObject($data);
        $this->assertEquals(
            array(
               'some nested string',
               'other nested string'
            ),
            $params->getValues('*.str')
        );

        $result = $params->getValues('nested.*');
        $this->assertTrue(is_array($result));
        $this->assertCount($nested_count, $result);
        $this->assertEquals('some nested string', $result[0]);
        $this->assertContains('second level', $result);
    }

    public function testSearchMultiSelectListExpression()
    {
        $data = $this->getExampleValues();
        $params = new ConfigurableArrayObject($data);

        $result = $params->getValues('[str, nested.str]');
        $this->assertTrue(is_array($result));
        $this->assertCount(2, $result);
        $this->assertEquals('some string', $result[0]);
        $this->assertEquals('some nested string', $result[1]);
    }

    public function testSearchOrExpression()
    {
        $params = new ConfigurableArrayObject($this->getExampleValues());
        $this->assertEquals('second level', $params->getValues('nested."2nd level" || first_level'));
        $this->assertEquals('first level', $params->getValues('first_level || nested."2nd level"'));
    }

    /**
     * @expectedException \JmesPath\SyntaxErrorException
     */
    public function testSearchSyntaxErrorException()
    {
        $data = $this->getExampleValues();
        $params = new ConfigurableArrayObject($data);

        $result = $params->getValues('[str, nested.str'); // missing closing ]
    }

    public function testRecursiveGet()
    {
        $params = new ConfigurableArrayObject($this->getExampleValues());
        $this->assertEquals('second level', $params->get('nested')->get("2nd level"));
    }

    public function testDeepArrayModification()
    {
        $params = new ConfigurableArrayObject($this->getExampleValues());
        $params->get('nested')->add(array('omg' => 'yes'));
        $this->assertEquals('yes', $params->get('nested')->get('omg'));
        $this->assertEquals('yes', $params->getValues('nested.omg'));
    }

    public function testEach()
    {
        $params = new ConfigurableArrayObject($this->getExampleValues());
        $random_int = function($key, $value) {
            if ($key === 'int') {
                return '3'; // chosen by fair dice roll
            }
            return $value;
        };
        $params->map($random_int);
        $this->assertEquals('3', $params->int);
    }

    public function testKsort()
    {
        $params = new ConfigurableArrayObject($this->getExampleValues());
        $keys = $params->getKeys();
        $params->ksort();
        $keys_new = $params->getKeys();
        sort($keys);
        $this->assertEquals($keys, $keys_new);
    }

    public function testIterator()
    {
        $params = new ConfigurableArrayObject($this->getExampleValues());
        $iter = $params->getIterator();
        $this->assertTrue($iter instanceof \ArrayIterator);
    }

    public function testGetArrayCopy()
    {
        $params = new ConfigurableArrayObject($this->getExampleValues());
        $array = $params->getArrayCopy();
        $this->assertTrue(is_array($array));
        $this->assertTrue(is_array($array['nested']));
    }

    public function testDeepClone()
    {
        $params = new ConfigurableArrayObject($this->getExampleValues());
        $clone = clone $params;
        $this->assertTrue($params == $clone);
        $this->assertFalse($params === $clone);
        $clone->nested->str = 'asdf';
        $this->assertNotEquals($params->nested->str, $clone->nested->str);
        $this->assertFalse($params == $clone);
        $this->assertFalse($params === $clone);
    }

    public function testArrayModificationByReference()
    {
        $params = new ConfigurableArrayObject($this->getExampleValues());
        $nested = $params->get('nested');
        $nested->set('by', 'reference');
        $this->assertEquals('reference', $params->get('nested')->get('by'));
        $params['nested'] = array('str' => 'asdf');
        $this->assertEquals($params->nested->str, $params->get('nested')['str']);
    }

    public function testToString()
    {
        $params = new ConfigurableArrayObject(array('foo' => 'bar'));
        $expected = <<<EOT
array (
  'foo' => 'bar',
)
EOT;
        $this->assertEquals($expected, (string)$params);
    }

    public function testAppendNumericIndizes()
    {
        $params = new ConfigurableArrayObject($this->getExampleValues());
        $params->append('by');
        $params->set(1, 'ref');
        $params[] = 'srsly';
        $this->assertEquals('by', $params->get(0));
        $this->assertEquals('ref', $params->get(1));
        $this->assertEquals('srsly', $params[2]);
    }

    public function testSampleElasticSearchUseCase()
    {
        $params = new ConfigurableArrayObject($this->getExampleElasticSearchQueryAsArray());
        $params->filter->bool->must[1]->term->live = false;
        $this->assertFalse($params->filter->bool->must[1]->get('term')->live);
    }

    public function testJsonSerializable()
    {
        $params = new ConfigurableArrayObject($this->getExampleElasticSearchQueryAsArray());
        json_encode($params, JSON_PRETTY_PRINT);
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());
    }
}
