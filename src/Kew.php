<?php

namespace BrekiTomasson;

use BrekiTomasson\Kew\AbstractKew;
use BrekiTomasson\Kew\Exceptions\KewIsEmpty;
use BrekiTomasson\Kew\Exceptions\KewTypeInvalid;
use BrekiTomasson\Kew\Queue;
use BrekiTomasson\Kew\Stack;

class Kew extends AbstractKew {

    protected $listsize = 0;
    protected $next;
    protected $last;
    protected $type;
    protected $list = [];
    protected $options;

    /**
     * @param array $options
     *
     * @return mixed
     */
    public function construct($options = [])
    {
        AbstractKew::__construct($options);
    }

    /**
     * @param $item
     * @param mixed ...$items
     *
     * @return void
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     */
    public function add($item, ...$items)
    {
        // Define our resource type.
        if ($this->isEmpty() === true) {
            $this->type = \gettype($item);
            $this->last = $item;
        } elseif (\gettype($item) !== $this->type) {
            throw new KewTypeInvalid('Expected ' . $this->type . ', got ' . \gettype($item) . '.');
        }

        $this->list[] = $item;
        $this->next = $item;
        ++$this->listsize;

        if ($items) {
            $item = array_pop($items);
            $this->add($item, $items);
        }

    }

    public function haxx() {
        print_r($this->list);
    }

    public function bottom()
    {
        // TODO: Implement bottom() method.
    }

    public function get()
    {
        // TODO: Implement get() method.
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->size() === 0;
    }

    public function last()
    {
        // TODO: Implement last() method.
    }

    public function next()
    {
        // TODO: Implement next() method.
    }

    public function pop()
    {
        // TODO: Implement pop() method.
    }

    public function push()
    {
        // TODO: Implement push() method.
    }

    /**
     * @return int
     */
    public function size(): int
    {
        return $this->listsize ?: 0;
    }

    public function top()
    {
        // TODO: Implement top() method.
    }
}
