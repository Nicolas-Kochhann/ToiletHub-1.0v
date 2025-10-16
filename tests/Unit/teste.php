<?php
require __DIR__."/../../vendor/autoload.php";

use Src\Models\User;

$r = new User('nicolas@gmail.com', 'nicolas');
$r->setPassword('Vi@!9fz');
$r->save();