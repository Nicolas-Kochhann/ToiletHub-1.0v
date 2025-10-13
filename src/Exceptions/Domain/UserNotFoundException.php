<?php

namespace Src\Exceptions\Domain;
use RuntimeException;
use Throwable;

class UserNotFoundException extends RuntimeException {

    public function __construct(string $message = "User not found", $code = 0, ?Throwable $previous = null){
        parent::__construct($message, $code, $previous);
    }

}