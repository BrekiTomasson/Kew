<?php

namespace spec\BrekiTomasson\Kew;

use BrekiTomasson\Kew\AbstractKew;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AbstractKewSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AbstractKew::class);
    }
}
