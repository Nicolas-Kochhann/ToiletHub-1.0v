<?php

namespace Src\Exceptions\Domain;
use RuntimeException;
use Throwable;

class UploadException extends RuntimeException {

    public function __construct(string $message = "Upload failed.", $code = 0, ?Throwable $previous = null){
        parent::__construct($message, $code, $previous);
    }

}