<?php

class EmailAlreadyExistsException extends RuntimeException {

    public function __construct(string $message = "This email already exists", $code = 0, Throwable $previous = null){
        parent::__construct($message, $code, $previous);
    }

}