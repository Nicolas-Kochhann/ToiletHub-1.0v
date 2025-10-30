<?php
require __DIR__."/../../vendor/autoload.php";

use Src\Models\Bathroom;
use Src\Models\Uploader;

$images = Bathroom::findBathroomImages((int)$_GET['bathroomId']);
Uploader::deleteImages($images);

Bathroom::delete((int)$_GET['bathroomId']);

header( "Location: ../list-bathrooms/" );

?>