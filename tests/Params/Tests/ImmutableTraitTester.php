<?php

namespace Params\Tests;

use Params\Immutable\ImmutableParameters;
use Params\Immutable\ImmutableParametersTrait;
use Params\Immutable\ImmutableOptions;
use Params\Immutable\ImmutableOptionsTrait;

class ImmutableTraitTester
{
    use ImmutableParametersTrait;/* {
        ImmutableParametersTrait::getParameters as public omgParameters;
    }*/

    use \Params\Immutable\ImmutableOptionsTrait;
    //use \Params\Immutable\ImmutableSettingsTrait;

    public function __construct($init = true)
    {
        if ($init) {
            $this->parameters = new ImmutableParameters(array('foo' => 'bar'));
            $this->options = new ImmutableOptions(array('foo' => 'bar'));
        }
    }
}
