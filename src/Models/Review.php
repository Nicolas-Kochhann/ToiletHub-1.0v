<?php

namespace Src\Models;

use Src\Database\MySQL;
use Src\Interfaces\ActiveRecord;
use ReviewNotFoundException;

class Review implements ActiveRecord{
    private int $reviewId;
    private string $comment;
    private Bathroom $bathroom;
    private User $user;

    public function save(): bool{
        $conn = MySQL::connect();
        if($this->userId){
            $sql = "UPDATE reviews SET comment=:comment WHERE reviewId=:reviewId";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'comment' => $this->comment
            ]);
        } else {
            $sql = "INSERT INTO reviews(comment, bathroomId, userId) VALUES(:comment, :bathroomId, :userId)";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'comment' => $this->comment,
                'bathroomId' => $this->bathroom,
                'userId' => $this->user
            ]);
        }
        return $result;
    }

    public function delete(): bool{
        $conn = MySQL::connect();
        $sql = "DELETE FROM reviews WHERE reviewId=:reviewId";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['reviewId' => $this->reviewId]);
        return $result;
    }

    public static function find($reviewId): Review{
        $conn = MySQL::connect();
        $sql = "SELECT b.comment AS comment, b.* AS bathroom, u.* AS user FROM reviews r
                JOIN users u ON u.userId=r.userId
                JOIN bathrooms b ON b.bathroomId = r.bathroomId
                WHERE reviewId=:reviewId";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['reviewId' => $reviewId]);
        $review = $stmt->fetch();
        
        if(!$user){
            throw new ReviewNotFoundException();
        }

        return new Review($review['comment'], $user['bathroom'], $user['user']);
    }

    public static function listAll(): array{
        $conn = MySQL::connect();
        $sql = "SELECT b.comment AS comment, b.* AS bathroom, u.* AS user FROM reviews r
                JOIN users u ON u.userId=r.userId
                JOIN bathrooms b ON b.bathroomId = r.bathroomId";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        $reviews = [];
        foreach($results as $result){
            $review = new Review($review['comment'], $user['bathroom'], $user['user']);
            $reviews[] = $review;
        }
        return $users;
    }
}