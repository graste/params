<?php

namespace Params\Tests;

use Params\ConfigurableArrayObject;
use Params\Tests\Fixtures\TraitTester;

class TraitTest extends BaseTestCase
{
    public function testFluentApi()
    {
        $p = new TraitTester();

        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->setParameter('foo', 'bar'));
        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->addParameters(array('foo', 'bar')));
        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->removeParameter('foo'));
        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->clearParameters());
        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->setParameters(array('foo', 'bar')));

        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->setOption('foo', 'bar'));
        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->addOptions(array('foo', 'bar')));
        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->removeOption('foo'));
        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->clearOptions());
        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->setOptions(array('foo', 'bar')));

        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->setSetting('foo', 'bar'));
        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->addSettings(array('foo', 'bar')));
        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->removeSetting('foo'));
        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->clearSettings());
        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->setSettings(array('foo', 'bar')));
    }

    public function testSettingConfigurableArrayObjectWorks()
    {
        $p = new TraitTester();

        $a = new ConfigurableArrayObject();
        $a['foo'] = 'bar';
        $a['bar'] = 'baz';
        $this->assertEquals('bar', $a['foo']);

        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->setParameters($a));
        $this->assertEquals('bar', $p->getParameter('foo'));

        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->setOptions($a));
        $this->assertEquals('bar', $p->getOption('foo'));

        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->setSettings($a));
        $this->assertEquals('bar', $p->getSetting('foo'));
    }

    public function testAddingConfigurableArrayObjectWorks()
    {
        $p = new TraitTester();

        $a = new ConfigurableArrayObject();
        $a['foo'] = 'bar';
        $a['bar'] = 'baz';
        $this->assertEquals('bar', $a['foo']);
        $b = new ConfigurableArrayObject();
        $b['foo'] = 'barbaz';

        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->addParameters($a));
        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->addParameters($a));
        $this->assertEquals('bar', $p->getParameter('foo'));

        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->addOptions($a));
        $this->assertEquals('bar', $p->getOption('foo'));

        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->addSettings($a));
        $this->assertEquals('bar', $p->getSetting('foo'));
    }

    public function testReaddingExistingKeysViaConfigurableArrayObjectIsIgnoredIfWanted()
    {
        $p = new TraitTester();

        $a = new ConfigurableArrayObject();
        $a['foo'] = 'bar';
        $this->assertEquals('bar', $a['foo']);
        $b = new ConfigurableArrayObject();
        $b['foo'] = 'barbaz';
        $this->assertEquals('barbaz', $b['foo']);

        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->addParameters($a));
        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->addParameters($b, false));
        $this->assertEquals('bar', $p->getParameter('foo'));
        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->addParameters($b));
        $this->assertEquals('barbaz', $p->getParameter('foo'));

        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->addOptions($a));
        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->addOptions($b, false));
        $this->assertEquals('bar', $p->getOption('foo'));
        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->addOptions($b));
        $this->assertEquals('barbaz', $p->getOption('foo'));

        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->addSettings($a));
        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->addSettings($b, false));
        $this->assertEquals('bar', $p->getSetting('foo'));
        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->addSettings($b));
        $this->assertEquals('barbaz', $p->getSetting('foo'));
    }

    public function testOptionsAreLostWhenCopyingParamsViaAddParams()
    {
        $p = new TraitTester();

        $custom_iterator_class = 'Params\\Tests\\Fixtures\\CustomArrayIterator';

        $a = new ConfigurableArrayObject(
            [ 'foo' => 'bar' ],
            [ ConfigurableArrayObject::OPTION_ITERATOR => $custom_iterator_class ]
        );
        $this->assertEquals('bar', $a['foo']);
        $this->assertInstanceOf($custom_iterator_class, $a->getIterator());

        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->setParameters($a));
        $this->assertEquals('bar', $p->getParameter('foo'));
        $this->assertNotInstanceOf($custom_iterator_class, $p->getParameters()->getIterator());

        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->setOptions($a));
        $this->assertEquals('bar', $p->getOption('foo'));
        $this->assertNotInstanceOf($custom_iterator_class, $p->getOptions()->getIterator());

        $this->assertInstanceOf('\\Params\\Tests\\Fixtures\\TraitTester', $p->setSettings($a));
        $this->assertEquals('bar', $p->getSetting('foo'));
        $this->assertNotInstanceOf($custom_iterator_class, $p->getSettings()->getIterator());
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

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetSettingsThrowsOnWrongType()
    {
        $p = new TraitTester();
        $p->setSettings('trololo');
    }
}
