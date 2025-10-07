<?php

namespace Src\Models;

class Bathroom{
    private int $bathroomId;
    private bool $isPaid;
    private int $price;
    private int $lat;
    private int $long;
    private User $owner;
}