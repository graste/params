<?php

namespace Params\Tests;

use Params\Immutable\ImmutableOptions;

class ImmutableOptionsTest extends BaseTestCase
{
    public function testConstruct()
    {
        $p = new ImmutableOptions();

        $this->assertEquals(0, count($p->toArray()));
        $this->assertEquals(0, $p->count());
        $this->assertEmpty($p->getKeys());
    }

    public function testCreate()
    {
        $data = $this->getExampleValues();
        $params = new ImmutableOptions($data);

        $this->assertInstanceOf('\\Params\\Immutable\\ImmutableOptions', $params);
        $this->assertEquals($data['str'], $params->get('str'));
        $this->assertEquals($data['int'], $params->get('int'));
        $this->assertEquals($data['bool'], $params->get('bool'));
    }

    /**
     * @expectedException \LogicException
     */
    public function testSetValueViaArrayAccessFails()
    {
        $params = new ImmutableOptions();
        $params['obj'] = 'asdf';
    }

    /**
     * @expectedException \LogicException
     */
    public function testSetValueViaPropertyAccessFails()
    {
        $params = new ImmutableOptions();
        $params->obj = 'asdf';
    }

    /**
     * @expectedException \LogicException
     */
    public function testAppendFails()
    {
        $params = new ImmutableOptions();
        $params->append(array('foo' => 'omg'));
    }

    /**
     * @expectedException \LogicException
     */
    public function testUnsetFails()
    {
        $params = new ImmutableOptions(array('foo' => 'bar'));
        unset($params['foo']);
    }

    /**
     * @expectedException \LogicException
     */
    public function testExchangeArrayFails()
    {
        $params = new ImmutableOptions();
        $params->exchangeArray(array('foo' => 'omg'));
    }
}

