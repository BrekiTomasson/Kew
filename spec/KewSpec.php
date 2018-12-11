<?php

namespace spec\BrekiTomasson;

use BrekiTomasson\Kew;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class KewSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Kew::class);
    }

    public function it_can_add_things()
    {
        $this->add('alphabet')->shouldReturn(true);
    }
}
