<?php

namespace BrekiTomasson\Kew\Exceptions;

use Exception;

/**
 * Class KewIsEmpty
 *
 * @package BrekiTomasson\Kew\Exceptions
 */
class KewIsEmpty extends Exception
{
    /** @var string Error string. */
    protected $message = 'Queue is empty.';

    /** @var int Error code */
    protected $code = 1;
}
