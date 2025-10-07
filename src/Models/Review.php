<?php

namespace Src\Models;

class Review{
    private int $reviewId;
    private string $comment;
    private Bathroom $bathroom;
    private User $user;
}