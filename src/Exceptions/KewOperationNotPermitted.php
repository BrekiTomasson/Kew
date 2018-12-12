<?php

namespace BrekiTomasson\Kew\Exceptions;

use Exception;

class KewOperationNotPermitted extends Exception
{
    protected $message = 'I\'m sorry, Dave. I\'m afraid you cannot do that..';
    protected $code = 3;
}
