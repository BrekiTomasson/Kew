<?php

namespace BrekiTomasson\Kew;

use BrekiTomasson\Kew\Exceptions\KewIsEmpty;
use BrekiTomasson\Kew\Exceptions\KewTypeInvalid;

class Kew implements KewInterface
{
    private $listsize = 0;
    private $listnext;
    private $listlast;
    private $type;
    private $list = [];
    private $options;

    /**
     * @param array $options
     *
     * @return mixed
     */
    public function __construct($options = [])
    {
        $this->options = [
            'typed'    => true,
            'nextable' => true,
            'lastable' => true,
            'sizeable' => true,
            'readable' => true,
            'stack'    => false,
        ];

        foreach ($options as $key => $value) {
            $this->options[$key] = $value;
        }

        if ($this->options['readable'] === false) {
            $this->options['lastable'] = false;
            $this->options['nextable'] = false;
            $this->options['sizeable'] = false;
        }
    }

    /**
     * Adds one or more (comma separated) items to the queue.
     *
     * Note, trying to add an array will treat the array as a single item to be
     * added to the list.
     *
     * @param mixed $item
     * @param mixed ...$items
     *
     * @return void
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     */
    public function add($item, ...$items)
    {
        // Define our resource type.
        if ($this->isEmpty() === true) {
            $this->type = $this->options['typed'] ? \gettype($item) : null;
            $this->listnext = $this->options['nextable'] ? $item : null;
        } elseif (\gettype($item) !== $this->type && $this->options['typed'] === true) {
            throw new KewTypeInvalid('Expected ' . $this->type . ', got ' . \gettype($item) . '.');
        }

        $this->list[] = $item;
        $this->listlast = $item;
        ++$this->listsize;

        if (array_key_exists(0, $items)) {
            $this->addMany($items);
        }

    }

    /**
     * @return mixed
     */
    public function bottom()
    {
        return $this->last();
    }

    /**
     * @return mixed
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     */
    public function get()
    {
        // wrapping all these in a try to ensure we don't get half executions.
        try {
            $item = $this->prepareNextFIFO();

            if ($item !== null) {
                return $item;
            }

            throw new KewIsEmpty();
        } catch (KewIsEmpty $emptyException) {
            // Throw it higher up the stack.
            throw $emptyException;
        }
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return ! $this->size();
    }

    /**
     * @return mixed
     */
    public function last()
    {
        return $this->listlast;
    }

    /**
     * @return mixed
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     */
    public function next()
    {
        // Note that $this->listnext is hard-coded to 'null' if options['nextable'] is false.
        if ((bool) $this->listsize) {
            return $this->listnext;
        }

        throw new KewIsEmpty();
    }

    /**
     * @return mixed
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     */
    public function pop()
    {
        return $this->get();
    }

    /**
     * @return int
     */
    public function size(): int
    {
        return $this->listsize ?: 0;
    }

    /**
     * Alias method for next();
     *
     * @return mixed
     * @throws \BrekiTomasson\Kew\Exceptions\KewIsEmpty
     */
    public function top()
    {
        return $this->next();
    }

    /**
     * @param mixed $item
     * @param mixed ...$items
     *
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     */
    public function push($item, ...$items)
    {
        $this->add($item);

        if (array_key_exists(0, $items)) {
            $this->addMany($items);
        }
    }

    /**
     * Handles multiple additions coming as an array from add() or push().
     *
     * @param array $items
     *
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     */
    protected function addMany(array $items): void
    {
        while (array_key_exists(0, $items)) {
            $this->add(array_shift($items));
        }
    }

    /**
     * @return mixed
     */
    protected function prepareNextFIFO()
    {
        $item = \array_shift($this->list);

        if ($this->listsize >= 1) {
            --$this->listsize;
        }

        if (array_key_exists(0, $this->list)) {
            $this->listnext = $this->options['nextable'] ? $this->list[0] : null;
        } else {
            unset($this->listnext);
        }

        return $item;
    }
}
