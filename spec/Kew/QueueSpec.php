<?php

namespace spec\BrekiTomasson\Kew;

use BrekiTomasson\Kew\Queue;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QueueSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Queue::class);
    }
}
