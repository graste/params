<?php

namespace Params\Tests;

use Params\Immutable\ImmutableParameters;

class ImmutableParametersTest extends BaseTestCase
{
    public function testConstruct()
    {
        $p = new ImmutableParameters();

        $this->assertEquals(0, count($p->toArray()));
        $this->assertEquals(0, $p->count());
        $this->assertEmpty($p->getKeys());
    }

    public function testCreate()
    {
        $data = $this->getExampleValues();
        $params = new ImmutableParameters($data);

        $this->assertInstanceOf('\\Params\\Immutable\\ImmutableParameters', $params);
        $this->assertEquals($data['str'], $params->get('str'));
        $this->assertEquals($data['int'], $params->get('int'));
        $this->assertEquals($data['bool'], $params->get('bool'));
    }

    /**
     * @expectedException \LogicException
     */
    public function testSetValueViaArrayAccessFails()
    {
        $params = new ImmutableParameters();
        $params['obj'] = 'asdf';
    }

    /**
     * @expectedException \LogicException
     */
    public function testSetValueViaPropertyAccessFails()
    {
        $params = new ImmutableParameters();
        $params->obj = 'asdf';
    }

    /**
     * @expectedException \LogicException
     */
    public function testAppendFails()
    {
        $params = new ImmutableParameters();
        $params->append(array('foo' => 'omg'));
    }

    /**
     * @expectedException \LogicException
     */
    public function testUnsetFails()
    {
        $params = new ImmutableParameters(array('foo' => 'bar'));
        unset($params['foo']);
    }

    /**
     * @expectedException \LogicException
     */
    public function testExchangeArrayFails()
    {
        $params = new ImmutableParameters();
        $params->exchangeArray(array('foo' => 'omg'));
    }
}
