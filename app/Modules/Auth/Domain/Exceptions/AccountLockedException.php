<?php

namespace App\Modules\Auth\Domain\Exceptions;

use Exception;

class AccountLockedException extends Exception
{
    public function __construct(public string $message, public int $retryAfterSeconds)
    {
        parent::__construct($message);
    }
}
