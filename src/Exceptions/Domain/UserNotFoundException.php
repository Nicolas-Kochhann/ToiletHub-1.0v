<?php

class UserNotFoundException extends RuntimeException {

    public function __construct(string $message = "User not found", $code = 0, Throwable $previous = null){
        parent::__construct($message, $code, $previous);
    }

}