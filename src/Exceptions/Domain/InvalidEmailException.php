<?php

namespace Src\Exceptions\Domain;
use RuntimeException;
use Throwable;

class InvalidEmailException extends RuntimeException {

    public function __construct(string $message = "Invalid email", $code = 0, ?Throwable $previous = null){
        parent::__construct($message, $code, $previous);
    }

}