<?php
require "vendor/autoload.php";

use Src\Models\Review;
use Src\Models\User;


if(!isset($_SESSION['userId'])){
    http_response_code(401);
    echo json_encode(['error' => 'Usuário não autenticado']);
    exit;
}

if(!isset($_POST['comment']) || !isset($_POST['userId']) || !isset($_POST['bathroomId'])){
    http_response_code(400);
    echo json_encode(['error' => 'Parâmetros inválidos']);
    exit;
}

$comment = $_POST['comment'];
    $user = User::find($_POST[$_POST['userId']]);
    $bathroomId = $_POST['bathroomId'];

    $review = new Review($comment, $bathroomId, $user);
    if($review->save()){
        echo 'success';
    } else {
        echo 'error';
    }

    