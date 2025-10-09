<?php

class BathroomNotFoundException extends RuntimeException {

    public function __construct(string $message = "Bathroom not found", $code = 0, Throwable $previous = null){
        parent::__construct($message, $code, $previous);
    }

}