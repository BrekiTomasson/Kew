<?php

namespace BrekiTomasson\Kew;

interface KewInterface
{
    /**
     * @param array $options
     *
     * @return void
     */
    public function __construct($options = []);

    /**
     * @param mixed $item
     * @param mixed ...$items
     *
     * @return void
     */
    public function add($item, ...$items);

    /**
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * @param mixed $item
     * @param mixed ...$items
     *
     * @return mixed
     */
    public function push($item, ...$items);

    /**
     * @return int
     */
    public function size(): int;

    public function bottom();
    public function get();
    public function last();
    public function next();
    public function pop();
    public function top();

}
