<?php

namespace BrekiTomasson\Kew;

interface KewInterface
{
    /**
     * @param array $options
     *
     * @return void
     */
    public function construct($options = []);

    /**
     * @param $item
     * @param mixed ...$items
     *
     * @return void
     */
    public function add($item, ...$items);

    public function bottom();

    public function get();

    /**
     * @return bool
     */
    public function isEmpty() : bool;

    public function last();

    public function next();

    public function pop();

    public function push();

    /**
     * @return int
     */
    public function size() : int;

    public function top();
}
