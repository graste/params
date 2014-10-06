<?php

namespace Params\Tests;

class ImmutableTraitTest extends BaseTestCase
{
    public function testEmptyFailSafeConfig()
    {
        $p = new ImmutableTraitTester(false);
        $this->assertEquals(null, $p->getParameter('foo'));
        $this->assertEquals(null, $p->getOption('foo'));
        $this->assertEquals(null, $p->getSetting('foo'));
    }

    public function testGet()
    {
        $p = new ImmutableTraitTester();
        $this->assertEquals('bar', $p->getParameter('foo'));
        $this->assertEquals('bar', $p->getOption('foo'));
        $this->assertEquals('bar', $p->getSetting('foo'));
    }

    public function testHas()
    {
        $p = new ImmutableTraitTester();
        $this->assertTrue($p->hasParameter('foo'));
        $this->assertFalse($p->hasParameter('bar'));
        $this->assertTrue($p->hasOption('foo'));
        $this->assertFalse($p->hasOption('bar'));
        $this->assertTrue($p->hasSetting('foo'));
        $this->assertFalse($p->hasSetting('bar'));
    }

    public function testGetValues()
    {
        $p = new ImmutableTraitTester();
        $this->assertEquals(array('bar'), $p->getParameterValues());
        $this->assertEquals(array('bar'), $p->getOptionValues());
        $this->assertEquals(array('bar'), $p->getSettingValues());
    }

    public function testGetAsArray()
    {
        $p = new ImmutableTraitTester();
        $this->assertEquals(array('foo' => 'bar'), $p->getParametersAsArray());
        $this->assertEquals(array('foo' => 'bar'), $p->getOptionsAsArray());
        $this->assertEquals(array('foo' => 'bar'), $p->getSettingsAsArray());
    }

    /**
     * @expectedException \LogicException
     */
    public function testSetParametersThrows()
    {
        $p = new ImmutableTraitTester();
        $p->getParameters()['trololo'] = 'yes';
    }

    /**
     * @expectedException \LogicException
     */
    public function testSetOptionsThrows()
    {
        $p = new ImmutableTraitTester();
        $p->getOptions()['trololo'] = 'yes';
    }

    /**
     * @expectedException \LogicException
     */
    public function testSetSettingsThrows()
    {
        $p = new ImmutableTraitTester();
        $p->getSettings()['trololo'] = 'yes';
    }
}
