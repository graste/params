<?php

namespace Params\Tests\Fixtures;

class CustomArrayIterator extends \ArrayIterator
{
    public function getTrue() {
        return true;
    }
}
