<?php

namespace Src\Exceptions\Domain;
use RuntimeException;
use Throwable;

class InvalidPasswordException extends RuntimeException {

    public function __construct(string $message = "Invalid password", $code = 0, ?Throwable $previous = null){
        parent::__construct($message, $code, $previous);
    }

}