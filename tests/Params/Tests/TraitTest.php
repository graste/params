<?php

namespace Params\Tests;

class TraitTest extends BaseTestCase
{
    public function testFluentApi()
    {
        $p = new TraitTester();

        $this->assertInstanceOf('\\Params\\Tests\\TraitTester', $p->setParameter('foo', 'bar'));
        $this->assertInstanceOf('\\Params\\Tests\\TraitTester', $p->addParameters(array('foo', 'bar')));
        $this->assertInstanceOf('\\Params\\Tests\\TraitTester', $p->removeParameter('foo'));
        $this->assertInstanceOf('\\Params\\Tests\\TraitTester', $p->clearParameters());
        $this->assertInstanceOf('\\Params\\Tests\\TraitTester', $p->setParameters(array('foo', 'bar')));

        $this->assertInstanceOf('\\Params\\Tests\\TraitTester', $p->setOption('foo', 'bar'));
        $this->assertInstanceOf('\\Params\\Tests\\TraitTester', $p->addOptions(array('foo', 'bar')));
        $this->assertInstanceOf('\\Params\\Tests\\TraitTester', $p->removeOption('foo'));
        $this->assertInstanceOf('\\Params\\Tests\\TraitTester', $p->clearOptions());
        $this->assertInstanceOf('\\Params\\Tests\\TraitTester', $p->setOptions(array('foo', 'bar')));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetParametersThrowsOnWrongType()
    {
        $p = new TraitTester();

        $p->setParameters('trololo');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetOptionsThrowsOnWrongType()
    {
        $p = new TraitTester();

        $p->setOptions('trololo');
    }
}
