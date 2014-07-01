<?php

namespace Params\Tests;

use Params\Parameters;

class ParametersTraitTest extends BaseTestCase
{
    public function testConstruct()
    {
        $p = new ParametersTraitTester();

        $this->assertEquals(0, count($p->getParametersAsArray()));
        $this->assertEmpty($p->getParameterKeys());
    }

    public function testCreate()
    {
        $data = $this->getExampleValues();
        $params = new ParametersTraitTester();
        $params->setParameters($data);

        $this->assertInstanceOf('\\Params\\Parameters', $params->getParameters());
        $this->assertEquals($data['str'], $params->getParameter('str'));
        $this->assertEquals($data['int'], $params->getParameter('int'));
        $this->assertEquals($data['bool'], $params->getParameter('bool'));
    }

    public function testgetParametersAsArray()
    {
        $data = $this->getExampleValues();
        $params = new ParametersTraitTester();
        $params->setParameters($data);

        $this->assertEquals($data, $params->getParametersAsArray());
    }

    public function testGetDefaultValues()
    {
        $params = new ParametersTraitTester();
        $params->setParameters(
            new Parameters(
                array(
                    'nil' => null,
                    'null_as_string' => '0',
                    'null_as_int' => 0
                )
            )
        );

        $this->assertEquals('default', $params->getParameter('non_existant', 'default'));
        $this->assertFalse($params->hasParameter('non_existant'));

        $this->assertEquals(null, $params->getParameter('nil', 'default'));
        $this->assertTrue($params->hasParameter('nil'));
        $this->assertFalse($params->hasParameter('NIL'));

        $this->assertEquals('0', $params->getParameter('null_as_string', 'default'));
        $this->assertTrue($params->hasParameter('null_as_string'));
        $this->assertFalse($params->hasParameter('Null_as_string'));

        $this->assertEquals(0, $params->getParameter('null_as_int', 'default'));
        $this->assertTrue($params->hasParameter('null_as_int'));
        $this->assertFalse($params->hasParameter('Null_as_int'));
    }

    public function testSetValue()
    {
        $params = new ParametersTraitTester();
        $params->setParameters(array('foo' => 'trololo'));
        $params->setParameter('foo', 'bar');
        $params->setParameter('nil', null);

        $this->assertEquals('bar', $params->getParameter('foo', 'default'));
        $this->assertEquals(null, $params->getParameter('nil', 'default'));
    }

    public function testSet()
    {
        $params = new ParametersTraitTester();
        $params->getParameters()['foo'] = 'bar';
        $params->getParameters()->blah = 'blub';
        $this->assertEquals('bar', $params->getParameters()->foo);
        $this->assertEquals('blub', $params->getParameters()['blah']);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetEmptyKeyFails()
    {
        $params = new ParametersTraitTester();
        $params->setParameters(array('foo' => 'trololo'));
        $params->setParameter('', 'bar');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetNullKeyFails()
    {
        $params = new ParametersTraitTester();
        $params->setParameters(array('foo' => 'trololo'));
        $params->setParameter(null, 'bar');
    }

    public function testSetDoesntReplace()
    {
        $params = new ParametersTraitTester();
        $params->setParameters(array('foo' => 'bar'));
        $params->setParameter('foo', 'omg', false);
        $this->assertEquals('bar', $params->getParameter('foo'));
        $params->setParameter('foo', 'omg', true);
        $this->assertEquals('omg', $params->getParameter('foo'));
    }

    public function testAddDoesntReplace()
    {
        $params = new ParametersTraitTester();
        $params->setParameters(array('foo' => 'bar'));
        $params->addParameters(array('foo' => 'omg'), false);
        $this->assertEquals('bar', $params->getParameter('foo'));
        $params->addParameters(array('foo' => 'omg'), true);
        $this->assertEquals('omg', $params->getParameter('foo'));
    }

    public function testSetParametersAsParameters()
    {
        $params = new ParametersTraitTester();
        $params->setParameters(new Parameters(array('foo' => 'bar')));

        $this->assertEquals('bar', $params->getParameter('foo'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetInvalidParametersFails()
    {
        $params = new ParametersTraitTester();
        $params->setParameters('trololo');
    }

    public function testFluentApi()
    {
        $params = new ParametersTraitTester();
        $params->setParameters(array('foo' => 'trololo'));

        $this->assertInstanceOf('Params\Parameters', $params->setParameter('fluent', 'yes'));
        $this->assertInstanceOf('Params\Parameters', $params->addParameters(array('api' => 'stuff')));
    }

    public function testGetKeys()
    {
        $params = new ParametersTraitTester();
        $params->setParameters(array('foo' => 'trololo'));
        $params->setParameter('foo', 'bar');
        $params->setParameter('nil', null);

        $this->assertEquals(array('foo', 'nil'), $params->getParameterKeys());
    }

    public function testClearValues()
    {
        $params = new ParametersTraitTester();
        $params->setParameters(array('foo' => 'trololo'));
        $params->clearParameters();

        $this->assertEquals(array(), $params->getParametersAsArray());
    }

    public function testRemove()
    {
        $params = new ParametersTraitTester();
        $params->setParameters(array('foo' => 'bar'));
        $foo = $params->removeParameter('foo');
        $this->assertFalse($params->hasParameter('foo'));
        $this->assertEquals('bar', $foo);
    }

    public function testAddArray()
    {
        $params = new ParametersTraitTester();
        $params->setParameters(array('foo' => 'bar'));
        $new = array('foo' => 'omg', 'blah' => 'blub');
        $params->addParameters($new);
        $this->assertEquals(
            array(
                'foo' => 'omg',
                'blah' => 'blub'
            ),
            $params->getParametersAsArray()
        );
    }

    public function testAddParameters()
    {
        $params = new ParametersTraitTester();
        $params->setParameters(array('foo' => 'bar'));
        $new_params = new Parameters(array('foo' => 'omg', 'blah' => 'blub'));
        $params->addParameters($new_params);
        $this->assertEquals(
            array(
                'foo' => 'omg',
                'blah' => 'blub'
            ),
            $params->getParametersAsArray()
        );
    }

    public function testTypeChangeAndAddOnDeeperLevel()
    {
        $params = new ParametersTraitTester();
        $params->setParameters($this->getExampleValues());
        $new = array('foo' => 'omg', 'blah' => 'blub');
        $params->getParameter('nested')->set('bool', $new)->add($new);
        $this->assertEquals($new, $params->getParameter('nested')->get('bool')->toArray());
        $this->assertEquals($new, $params->searchParameters('nested.bool'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddInvalidType()
    {
        $params = new ParametersTraitTester();
        $params->setParameters(array('foo' => 'bar'));
        $params->addParameters(new \StdClass());
    }

    public function testSearchOrExpression()
    {
        $params = new ParametersTraitTester();
        $params->setParameters($this->getExampleValues());
        $this->assertEquals('second level', $params->searchParameters('nested."2nd level" || first_level'));
        $this->assertEquals('first level', $params->searchParameters('first_level || nested."2nd level"'));
    }

    public function testRecursiveGet()
    {
        $params = new ParametersTraitTester();
        $params->setParameters($this->getExampleValues());
        $this->assertEquals('second level', $params->getParameter('nested')->get("2nd level"));
    }

    public function testDeepArrayModification()
    {
        $params = new ParametersTraitTester();
        $params->setParameters($this->getExampleValues());
        $params->getParameter('nested')->add(array('omg' => 'yes'));
        $this->assertEquals('yes', $params->getParameter('nested')->get('omg'));
        $this->assertEquals('yes', $params->searchParameters('nested.omg'));
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

