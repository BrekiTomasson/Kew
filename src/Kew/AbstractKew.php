<?php

namespace BrekiTomasson\Kew;

abstract class AbstractKew implements KewInterface
{

    protected $options = [];

    /**
     * AbstractKew constructor.
     *
     * @param array $options
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
    }

}
