<?php

require_once  "../../../vendor/autoload.php";
use Src\Models\User;

$u = new User("luiz@gmail.com" , "luiz");
$u->setPassword(123);

// $u->save();