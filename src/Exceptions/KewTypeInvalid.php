<?php

namespace BrekiTomasson\Kew\Exceptions;

use Exception;

/**
 * Class KewTypeInvalid.
 */
class KewTypeInvalid extends Exception
{
    /** @var int Error code. */
    protected $code = 2;
}
