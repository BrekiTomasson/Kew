<?php

namespace BrekiTomasson\Kew\Exceptions;

use Exception;

/**
 * Class KewIsEmpty.
 */
class KewIsEmpty extends Exception
{
    /** @var string Error string. */
    protected $message = 'Queue is empty.';

    /** @var int Error code */
    protected $code = 1;
}
