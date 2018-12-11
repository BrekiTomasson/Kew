<?php

namespace spec\BrekiTomasson\Kew;

use BrekiTomasson\Kew\KewInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class KewInterfaceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(KewInterface::class);
    }
}
