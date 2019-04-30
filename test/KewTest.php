<?php

declare(strict_types=1);

namespace BrekiTomasson\KewTest;

use BrekiTomasson\Kew\Kew;
use PHPUnit\Framework\TestCase;

/**
 * Class KewTest.
 *
 * @covers \BrekiTomasson\Kew\Kew
 */
class KewTest extends TestCase
{
    /**
     * @testdox Create a new instance of the object
     * @covers  \BrekiTomasson\Kew\Kew
     */
    public function testCanBeCreated(): void
    {
        $kew = new Kew();
        $this->assertInstanceOf(Kew::class, $kew);
    }

    /**
     * @param $a
     * @param $b
     * @param $c
     * @param $d
     *
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @throws \BrekiTomasson\Kew\Exceptions\KewInternalConsistency
     * @covers       \BrekiTomasson\Kew\Kew::get
     * @covers       \BrekiTomasson\Kew\Kew::updateKew
     * @dataProvider sameTypeProvider
     * @testdox      Access the first value of the Kew
     */
    public function testGetFirstValue($a, $b, $c, $d): void
    {
        $kew = new Kew();
        $kew->add($a);
        $kew->add($b);
        $kew->add($c);
        $kew->add($d);
        $this->assertSame($a, $kew->next());
        $this->assertSame($a, $kew->get());
    }

    /**
     * @param $a
     * @param $b
     * @param $c
     * @param $d
     *
     * @throws \BrekiTomasson\Kew\Exceptions\KewInternalConsistency
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @covers       \BrekiTomasson\Kew\Kew::get
     * @covers       \BrekiTomasson\Kew\Kew::updateKew
     * @dataProvider sameTypeProvider
     * @testdox      Access the second value of the Kew
     */
    public function testGetSecondValue($a, $b, $c, $d): void
    {
        $kew = new Kew();
        $kew->add($a);
        $kew->add($b);
        $kew->add($c);
        $kew->add($d);

        $kew->get();

        $this->assertSame($b, $kew->next());
        $this->assertSame($b, $kew->get());
    }

    /**
     * @covers  \BrekiTomasson\Kew\Kew::isEmpty
     * @testdox Ensure that isEmpty() correctly evalueates empty Kews
     */
    public function testIsEmptyTrue(): void
    {
        $kew = new Kew();
        $this->assertTrue($kew->isEmpty());
    }

    /**
     * @covers  \BrekiTomasson\Kew\Kew::isEmpty
     * @testdox Ensure that isEmpty() correctly evalueates empty Kews
     *
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     */
    public function testIsEmptyFalse(): void
    {
        $kew = new Kew();
        $kew->add('No longer empty.');
        $this->assertFalse($kew->isEmpty());
    }

    /**
     * @covers \BrekiTomasson\Kew\Kew::add
     * @covers \BrekiTomasson\Kew\Kew::isEmpty
     *
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     */
    public function testAdd(): void
    {
        $kew = new Kew();
        $this->assertTrue($kew->isEmpty());
        $kew->add('The queue is no longer empty!');
        $this->assertFalse($kew->isEmpty());
    }

    /** @return array */
    public function sameTypeProvider(): array
    {
        return [
            'integers' => [123, 456, 789, 10101],
            'floats'   => [1.23, 2.18, 3.14, 4.56],
            'strings'  => ['John', 'Paul', 'George', 'Ringo'],
            'arrays'   => [[123, 'string'], ['string', 'another string'], ['string', 123], [123, 123, 512312]],
            'objects'  => [new \stdClass(), new \stdClass(), new \stdClass(), new \stdClass()],
        ];
    }

    /** @return array */
    public function differentTypeProvider(): array
    {
        return [
            'strings are not integers' => ['a string', 123],
            'integers are not floats'  => [123, 3.14],
            'floats are not strings'   => [6.18, 'a string'],
            'arrays are not strings'   => [['string'], 'string'],
            'arrays are not objects'   => [['this', 'is', 'an', 'array'], new \stdClass()],
        ];
    }

    /**
     * @covers       \BrekiTomasson\Kew\Kew::add
     * @covers       \BrekiTomasson\Kew\Kew::setKewType
     * @dataProvider differentTypeProvider
     * @expectedException \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     *
     * @param $a
     * @param $b
     *
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     */
    public function testExceptionAddingDifferentTypes($a, $b): void
    {
        $kew = new Kew();
        $kew->add($a);
        $kew->add($b);
    }

    /**
     * Essentially the same test as the one for Kew::last().
     *
     * @covers \BrekiTomasson\Kew\Kew::bottom
     *
     * @throws \BrekiTomasson\Kew\Exceptions\KewInternalConsistency
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     */
    public function testBottom(): void
    {
        $kew = new Kew();
        $kew->add('First', 'Middle', 'Last');
        $kew->get();
        $this->assertSame('Last', $kew->bottom());
    }

    /**
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @covers \BrekiTomasson\Kew\Kew::size
     */
    public function testSize(): void
    {
        $kew = new Kew();
        $kew->add('first item');
        $this->assertSame(1, $kew->size());
        $kew->add('second', 'third', 'fourth', 'fifth', 'sixth', 'seventh');
        $this->assertSame(7, $kew->size());
    }

    /**
     * Essentially the same as add().
     *
     * @covers       \BrekiTomasson\Kew\Kew::push
     *
     * @param $a
     * @param $b
     * @param $c
     * @param $d
     *
     * @throws \BrekiTomasson\Kew\Exceptions\KewInternalConsistency
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @dataProvider sameTypeProvider
     */
    public function testPush($a, $b, $c, $d): void
    {
        $kew = new Kew();
        $kew->push($a);
        $kew->push($b, $c, $d);
        $kew->get(); // removes $a
        $kew->get(); // removes $b
        $this->assertSame($c, $kew->get());
        $this->assertSame($d, $kew->get());
    }

    /**
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @covers  \BrekiTomasson\Kew\Kew::__construct
     * @test
     * @testdox Instantiate Kew with different options
     */
    public function itCanGetOptions(): void
    {
        $notReadable = new Kew(['readable' => false]);
        $notReadable->add('an item');
        $notReadable->add('another item');
        $this->assertNull($notReadable->next());
    }

    /**
     * @param $a
     * @param $b
     * @param $c
     * @param $d
     *
     * @throws \BrekiTomasson\Kew\Exceptions\KewInternalConsistency
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @covers       \BrekiTomasson\Kew\Kew::last
     * @dataProvider sameTypeProvider
     * @testdox      Read the last entry in the Kew
     */
    public function testLast($a, $b, $c, $d): void
    {
        $kew = new Kew();
        $kew->add($a, $b, $c, $d);
        $this->assertSame($d, $kew->last());
        $kew->get(); // Just to make sure last() doesn't change when you remove things from the head.
        $this->assertSame($d, $kew->last());
        $kew->add($a); // Just to make sure last() _does_ change when you add things to the tail.
        $this->assertSame($a, $kew->last());
    }

    /**
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @covers  \BrekiTomasson\Kew\Kew::get
     * @testdox Ensure that last() does not change the contents of a Kew
     */
    public function testLastDoesNotchangeContents(): void
    {
        $kew = new Kew();
        $kew->add('red');
        $kew->add('green');
        $kew->add('blue');
        $kew->add('cyan');
        $kew->add('green');
        $kew->add('yellow');

        $this->assertSame('yellow', $kew->last());
        $this->assertSame('yellow', $kew->bottom());
        $this->assertSame('yellow', $kew->last());
        $this->assertSame('yellow', $kew->bottom());
    }

    /**
     * This method is essentially the same as Kew::get().
     *
     * @covers       \BrekiTomasson\Kew\Kew::pop
     *
     * @param $a
     * @param $b
     * @param $c
     * @param $d
     *
     * @throws \BrekiTomasson\Kew\Exceptions\KewInternalConsistency
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @dataProvider sameTypeProvider
     */
    public function testPop($a, $b, $c, $d): void
    {
        $kew = new Kew();
        $kew->add($a, $b, $c, $d);
        $kew->get(); // remove $a from the queue
        $this->assertSame($b, $kew->pop());
    }

    /**
     * Shows you what's at the top of the pile, essentially the same as next():.
     *
     * @param $a
     * @param $b
     * @param $c
     * @param $d
     *
     * @throws \BrekiTomasson\Kew\Exceptions\KewInternalConsistency
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @covers       \BrekiTomasson\Kew\Kew::top
     * @dataProvider sameTypeProvider
     */
    public function testTop($a, $b, $c, $d): void
    {
        $kew = new Kew();
        $kew->add($a, $b, $c, $d);
        $this->assertSame($a, $kew->top());
        $kew->get();
        $this->assertSame($b, $kew->top());
    }

    /**
     * Displays the next value without removing it from the queue.
     *
     * @param $a
     * @param $b
     * @param $c
     * @param $d
     *
     * @throws \BrekiTomasson\Kew\Exceptions\KewInternalConsistency
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @covers       \BrekiTomasson\Kew\Kew::next
     * @dataProvider sameTypeProvider
     */
    public function testNext($a, $b, $c, $d): void
    {
        $kew = new Kew();
        $kew->add($a, $b, $c, $d);
        $this->assertSame($a, $kew->next());
        $kew->get();
        $this->assertSame($b, $kew->next());
    }

    /**
     * @param $a
     * @param $b
     * @param $c
     * @param $d
     *
     * @throws \BrekiTomasson\Kew\Exceptions\KewInternalConsistency
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @covers       \BrekiTomasson\Kew\Kew::add
     * @covers       \BrekiTomasson\Kew\Kew::addMany
     * @dataProvider sameTypeProvider
     */
    public function testAddMany($a, $b, $c, $d): void
    {
        $kew = new Kew();
        $kew->add($a, $b, $c, $d);
        $this->assertSame($a, $kew->get());
        $this->assertSame($b, $kew->get());
        $this->assertSame($c, $kew->get());
        $this->assertSame($d, $kew->get());
    }

    /**
     * @param $a
     * @param $b
     * @param $c
     * @param $d
     *
     * @throws \BrekiTomasson\Kew\Exceptions\KewInternalConsistency
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @dataProvider sameTypeProvider
     */
    public function testCreateNextFIFO($a, $b, $c, $d): void
    {
        $kew = new Kew();
        $kew->add($a, $b, $c, $d);

        // Check state
        $this->assertSame(4, $kew->size());
        $this->assertSame($a, $kew->next());

        // Remove one.
        $kew->pop();

        // Check state again.
        $this->assertSame(3, $kew->size());
        $this->assertSame($b, $kew->next());
    }

    /**
     * @throws \BrekiTomasson\Kew\Exceptions\KewInternalConsistency
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @expectedException \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     */
    public function testFailGettingFromEmptyKew(): void
    {
        $kew = new Kew();
        $kew->get();
    }

    /**
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @expectedException \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     */
    public function testFailNextingFromEmptyKew(): void
    {
        $kew = new Kew();
        $kew->next();
    }

    public function testSettingOptionThatDoesNotExist(): void
    {
        $kew = new Kew(['invisible' => true]);
        $this->assertNull($kew->getOption('invisible'));
    }

    /**
     * @throws \BrekiTomasson\Kew\Exceptions\KewInternalConsistency
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     * @covers \BrekiTomasson\Kew\Kew::add
     */
    public function testCreatingStackedKew(): void
    {
        $kew = new Kew(['stack' => true]);
        $kew->add('item one');
        $kew->add('item two');
        $this->assertSame('item two', $kew->get());
    }

    /**
     * @throws \BrekiTomasson\Kew\Exceptions\KewInternalConsistency
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     */
    public function testCreatingAndNextingStackedKew(): void
    {
        $kew = new Kew(['stack' => true]);
        $kew->add('one');
        $kew->add('two');
        $this->assertSame('two', $kew->next());
        $kew->add('three');
        $this->assertSame('three', $kew->get());
        $this->assertSame('two', $kew->get());
    }
}
