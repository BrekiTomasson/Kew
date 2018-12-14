<?php
declare(strict_types=1);

namespace BrekiTomasson\Kew;

use BrekiTomasson\Kew\Exceptions\KewInternalConsistency;
use BrekiTomasson\Kew\Exceptions\KewIsEmpty;
use BrekiTomasson\Kew\Exceptions\KewTypeInvalid;

/**
 * Class Kew
 *
 * @package BrekiTomasson\Kew
 * @version 1.0.1
 */
class Kew implements KewInterface
{
    /** @var int The amount of items in the Kew object. */
    private $listsize = 0;

    /** @var mixed The next item in the Kew object. */
    private $listnext;

    /** @var mixed The last item in the Kew object. */
    private $listlast;

    /** @var string The type of objects that the Kew object contains. */
    private $type;

    /** @var array The actual list that the Kew object interacts with. */
    private $list = [];

    /** @var array Any options relevant for the Kew object, with defaults. */
    private $options = [
        'typed'    => true,
        'nextable' => true,
        'lastable' => true,
        'sizeable' => true,
        'readable' => true,
        'stack'    => false,
    ];

    /**
     * @param array $options
     *
     * @return mixed
     */
    public function __construct($options = [])
    {
        if (\count($options) >= 1) {
            $this->setOption($options);
        }

        if ($this->getOption('readable') === false) {
            $this->setOption([
                'lastable' => false,
                'nextable' => false,
                'sizeable' => false
            ]);
        }
    }

    /**
     * @param array $options
     */
    public function setOption(array $options): void
    {
        foreach ($options as $key => $value) {
            if (array_key_exists($key, $this->options)) {
                $this->options[$key] = $value;
            }
        }
    }

    /**
     * @param string $field
     *
     * @return mixed|null
     */
    public function getOption(string $field)
    {
        if (array_key_exists($field, $this->options)) {
            return $this->options[$field];
        }

        return null;
    }

    /**
     * Adds one or more (comma separated) items to the queue.
     *
     * @param mixed $item
     * @param mixed ...$items
     *
     * @return void
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     */
    public function add($item, ...$items): void
    {
        $this->setKewType($item);
        $this->updateKew($item);

        if (\count($items) !== 0) {
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
     * @throws \BrekiTomasson\Kew\Exceptions\KewInternalConsistency
     */
    public function get()
    {
        // wrapping all these in a try to ensure we don't get half executions.
        try {
            $item = $this->getOption('stack') ? $this->getNextStacked() : $this->getNextQueued();

            if ($item === null) {
                throw new KewIsEmpty();
            }

            return $item;
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
     * @throws \BrekiTomasson\Kew\Exceptions\KewInternalConsistency
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
     * @throws \BrekiTomasson\Kew\Exceptions\KewInternalConsistency
     */
    protected function getNextQueued()
    {
        $item = \array_shift($this->list);

        if ($this->listsize >= 1) {
            --$this->listsize;
        }

        if (\count($this->list) !== $this->listsize) {
            throw new KewInternalConsistency('Kew item count mismatch error.');
        }

        if (array_key_exists(0, $this->list)) {
            $this->listnext = $this->options['nextable'] ? $this->list[0] : null;
        } else {
            unset($this->listnext);
        }

        return $item;
    }

    /**
     * @return mixed
     * @throws \BrekiTomasson\Kew\Exceptions\KewInternalConsistency
     */
    protected function getNextStacked()
    {
        $item = \array_pop($this->list);

        if ($this->listsize >= 1) {
            --$this->listsize;
        }

        if (\count($this->list) !== $this->listsize) {
            throw new KewInternalConsistency('Kew item count mismatch error.');
        }

        if (\count($this->list) !== 0) {
            $this->listnext = $this->options['nextable'] ? end($this->list) : null;
        } else {
            unset($this->listnext);
        }

        return $item;
    }

    /**
     * @param $item
     *
     * @throws \BrekiTomasson\Kew\Exceptions\KewTypeInvalid
     */
    protected function setKewType($item): void
    {
        if ($this->isEmpty() === true) {
            $this->type = $this->getOption('typed') ? \gettype($item) : null;
            $this->listnext = $this->getOption('nextable') ? $item : null;
            $this->listlast = $this->getOption('lastable') ? $item : null;
        } elseif ($this->options['typed'] === true && \gettype($item) !== $this->type) {
            throw new KewTypeInvalid('Expected ' . $this->type . ', got ' . \gettype($item) . '.');
        }
    }

    /**
     * @param $item
     */
    protected function updateKew($item): void
    {
        $this->list[] = $item;
        ++$this->listsize;

        if ($this->getOption('lastable')) {
            $this->listlast = $this->getOption('stack') ? reset($this->list) : end($this->list);
        }

        if ($this->getOption('nextable')) {
            $this->listnext = $this->getOption('stack') ? end($this->list) : reset($this->list);
        }
    }

}
