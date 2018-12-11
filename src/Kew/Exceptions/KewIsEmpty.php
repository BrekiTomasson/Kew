<?php

namespace BrekiTomasson\Kew\Exceptions;

use Exception;

class KewIsEmpty extends Exception
{
    protected $message = 'Queue is empty.';
    protected $code = 1;
}
