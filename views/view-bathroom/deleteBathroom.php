<?php
require __DIR__."/../../vendor/autoload.php";

use Src\Models\Bathroom;

Bathroom::delete((int)$_GET['bathroomId']);

header( "Location: ../list-bathrooms/" );

?>