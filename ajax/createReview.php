<?php
require "vendor/autoload.php";

use Src\Models\Review;
use Src\Models\User;

header('Content-Type: application/json');

if(!isset($_SESSION['userId'])){
    http_response_code(401);
    echo json_encode(['error' => 'Not authorized']);
    exit;
}

if(!isset($_POST['comment']) || !isset($_POST['userId']) || !isset($_POST['bathroomId'])){
    http_response_code(400);
    echo json_encode(['error' => 'Invalid arguments']);
    exit;
}

$comment = $_POST['comment'];
$user = User::find($_POST[$_POST['userId']]);
$bathroomId = $_POST['bathroomId'];

$review = new Review($comment, $bathroomId, $user);
if($review->save()){
    http_response_code(200);
    json_encode([
        'comment' => $comment,
        'username' => $user->getUsername(),
    ]);
    exit;
} else {
    json_ecode([
        'error' => 'Something went wrong with your comment';
    ])
    exit;
}

    