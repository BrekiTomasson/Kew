<?php

namespace BrekiTomasson\Kew\Exceptions;

use Exception;

/**
 * Class KewOperationNotPermitted
 *
 * @package BrekiTomasson\Kew\Exceptions
 */
class KewOperationNotPermitted extends Exception
{
    /** @var string Error string. */
    protected $message = 'I\'m sorry, Dave. I\'m afraid you cannot do that..';

    /** @var int Error code. */
    protected $code = 3;
}
