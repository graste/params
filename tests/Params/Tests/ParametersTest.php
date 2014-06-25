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
}

