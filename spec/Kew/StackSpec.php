<?php

namespace spec\BrekiTomasson\Kew;

use BrekiTomasson\Kew\Stack;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StackSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Stack::class);
    }
}
