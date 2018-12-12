<?php

namespace BrekiTomasson\KewTest;

use BrekiTomasson\Kew\Kew;
use PHPUnit\Framework\TestCase;

class KewTest extends TestCase
{

    /**
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @covers \BrekiTomasson\Kew\Kew::get()
     */
    public function testGetFirstValue()
    {
        $queue = new Kew();
        $queue->add('John', 'Paul', 'George', 'Ringo');
        $this->assertSame('John', $queue->get());
    }

    /**
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @covers \BrekiTomasson\Kew\Kew::get()
     */
    public function testGetSecondValue()
    {
        $queue = new Kew();
        $queue->add('John', 'Paul', 'George', 'Ringo');
        $queue->get();
        $this->assertSame('Paul', $queue->get());
    }

    /**
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @covers \BrekiTomasson\Kew\Kew::add()
     */
    public function testAdd()
    {
        $queue = new Kew();
        $this->assertTrue($queue->isEmpty());
        $queue->add('De-emptifier');
        $this->assertFalse($queue->isEmpty());
    }

    /**
     * @covers \BrekiTomasson\Kew\Kew::add()
     * @expectedException \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     */
    public function testExceptionAddingDifferentTypes()
    {
        $queue = new Kew();
        $queue->add('This is a string, but the next add is not!');
        $queue->add(1234566789);
    }

    /**
     * Essentially the same test as the one for Kew::last()
     *
     * @covers \BrekiTomasson\Kew\Kew::bottom()
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     */
    public function testBottom()
    {
        $queue = new Kew();
        $queue->add('First', 'Middle', 'Last');
        $queue->get();
        $this->assertSame('Last', $queue->bottom());
    }

    /**
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @covers \BrekiTomasson\Kew\Kew::size()
     */
    public function testSize()
    {
        $queue = new Kew();
        $queue->add('first item');
        $this->assertSame(1, $queue->size());
        $queue->add('second', 'third', 'fourth', 'fifth', 'sixth', 'seventh');
        $this->assertSame(7, $queue - $queue->size());
    }

    /**
     * Essentially the same as add().
     *
     * @covers \BrekiTomasson\Kew\Kew::push()
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     */
    public function testPush()
    {
        $queue = new Kew();
        $queue->push(123);
        $queue->push(456);
        $queue->push(789);
        $queue->get();
        $queue->get();
        $this->assertThat(789, $queue->get());
    }

    /**
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @covers \BrekiTomasson\Kew\Kew::__construct();
     */
    public function test__construct()
    {
        $notReadable = new Kew(['readable' => false]);
        $notReadable->add('an item');
        $notReadable->add('another item');
        $this->assertNull($notReadable->next());
    }

    /**
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @covers \BrekiTomasson\Kew\Kew::last
     */
    public function testLast()
    {
        $queue = new Kew();
        $queue->add('First', 'Middle', 'Last');
        $queue->get();
        $this->assertSame('Last', $queue->last());
    }

    /**
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @covers \BrekiTomasson\Kew\Kew::get()
     */
    public function testLastDoesNotchangeContents()
    {
        $queue = new Kew();
        $queue->add('red');
        $queue->add('green');
        $queue->add('blue');
        $queue->add('cyan');
        $queue->add('green');
        $queue->add('yellow');

        $this->assertSame('yellow', $queue->last());
        $this->assertSame('yellow', $queue->bottom());
        $this->assertSame('yellow', $queue->last());
        $this->assertSame('yellow', $queue->bottom());

    }

    /**
     * This method is essentially the same as Kew::get().
     *
     * @covers \BrekiTomasson\Kew\Kew::pop()
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     */
    public function testPop()
    {
        $queue = New Kew();
        $queue->add('Finn the Human', 'Jake the Dog');
        $queue->get();
        $this->assertSame('Jake the Dog', $queue->pop());
    }

    /**
     * Shows you what's at the top of the pile, essentially the same as next():
     *
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @covers \BrekiTomasson\Kew\Kew::top()
     */
    public function testTop()
    {
        $queue = new Kew();
        $queue->add('MacOS', 'Windows', 'Linux');
        $this->assertSame('MacOS', $queue->next());
        $this->assertSame('MacOS', $queue->top());
    }

    /**
     * Returns true if there are 0 items in queue, fals otherwise.
     *
     * covers Kew::isEmpty()
     */
    public function testIsEmpty()
    {
        $queue = new Kew();
        $this->assertTrue($queue->isEmpty());
    }

    /**
     * Displays the next value without removing it from the queue.
     *
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @covers \BrekiTomasson\Kew\Kew::next()
     */
    public function testNext()
    {
        $queue = new Kew();
        $queue->add('Red', 'Green', 'Blue');
        $this->assertSame('Red', $queue->next());
    }

    /**
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     */
    public function testCreateNextFIFO()
    {
        $queue = new Kew();
        $queue->add('sugar');
        $queue->add('eggs');
        $queue->add('milk');

        // Check state
        $this->assertSame(3, $queue->size());
        $this->assertSame('sugar', $queue->next());

        // Remove one.
        $queue->pop();

        // Check state again.
        $this->assertSame(2, $queue->size());
        $this->assertSame('eggs', $queue->next());

    }
}
