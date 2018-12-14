<?php

declare(strict_types=1);

namespace BrekiTomasson\Kew\Exceptions;

use Exception;

/**
 * Class KewInternalConsistency
 *
 * @package BrekiTomasson\Kew\Exceptions
 */
class KewInternalConsistency extends Exception
{
    /** @var int Error code */
    protected $code = 4;
}
