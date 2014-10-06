<?php

namespace Params\Tests;

use Params\Immutable\ImmutableSettings;

class ImmutableSettingsTest extends BaseTestCase
{
    public function testConstruct()
    {
        $p = new ImmutableSettings();

        $this->assertEquals(0, count($p->toArray()));
        $this->assertEquals(0, $p->count());
        $this->assertEmpty($p->getKeys());
    }

    public function testCreate()
    {
        $data = $this->getExampleValues();
        $params = new ImmutableSettings($data);

        $this->assertInstanceOf('\\Params\\Immutable\\ImmutableSettings', $params);
        $this->assertEquals($data['str'], $params->get('str'));
        $this->assertEquals($data['int'], $params->get('int'));
        $this->assertEquals($data['bool'], $params->get('bool'));
    }

    /**
     * @expectedException \LogicException
     */
    public function testSetValueViaArrayAccessFails()
    {
        $params = new ImmutableSettings();
        $params['obj'] = 'asdf';
    }

    /**
     * @expectedException \LogicException
     */
    public function testSetValueViaPropertyAccessFails()
    {
        $params = new ImmutableSettings();
        $params->obj = 'asdf';
    }

    /**
     * @expectedException \LogicException
     */
    public function testAppendFails()
    {
        $params = new ImmutableSettings();
        $params->append(array('foo' => 'omg'));
    }

    /**
     * @expectedException \LogicException
     */
    public function testUnsetFails()
    {
        $params = new ImmutableSettings(array('foo' => 'bar'));
        unset($params['foo']);
    }

    /**
     * @expectedException \LogicException
     */
    public function testExchangeArrayFails()
    {
        $params = new ImmutableSettings();
        $params->exchangeArray(array('foo' => 'omg'));
    }
}

