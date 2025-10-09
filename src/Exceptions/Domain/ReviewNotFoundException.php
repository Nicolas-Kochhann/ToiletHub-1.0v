<?php

class ReviewNotFoundException extends RuntimeException {

    public function __construct(string $message = "Review not found", $code = 0, Throwable $previous = null){
        parent::__construct($message, $code, $previous);
    }

}