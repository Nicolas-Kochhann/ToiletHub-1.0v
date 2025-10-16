<?php

namespace Src\Models;

use Src\Database\MySQL;
use Src\Interfaces\ActiveRecord;
use Src\Exceptions\Domain\ReviewNotFoundException;

class Review implements ActiveRecord{
    private int $reviewId;
    private string $comment;
    private int $bathroomId;
    private User $user;

    public function __construct(string $comment, int $bathroomId, User $user){
        $this->comment = $comment;
        $this->bathroomId = $bathroomId;
        $this->user = $user;
    }


    public function save(): bool{
        $conn = MySQL::connect();
        if($this->reviewId){
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
                'bathroomId' => $this->bathroomId,
                'userId' => $this->user->getUserId()
            ]);
        }
        return $result;
    }

    public static function delete(int $reviewId): bool{
        $conn = MySQL::connect();
        $sql = "DELETE FROM reviews WHERE reviewId=:reviewId";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['reviewId' => $reviewId]);
        return $result;
    }

    public static function find(int $reviewId): Review{
        $conn = MySQL::connect();
        $sql = "SELECT r.comment AS comment, 
                b.bathroomId AS bathroomId, 
                u.email AS user_email, u.username AS username, u.profilePicture AS user_picture 
                FROM reviews r
                JOIN users u ON u.userId=r.userId
                JOIN bathrooms b ON b.bathroomId = r.bathroomId
                WHERE reviewId=:reviewId";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['reviewId' => $reviewId]);
        $review = $stmt->fetch();
        
        if(!$reviewId){
            throw new ReviewNotFoundException();
        }

        $user = new User($review['email'], $review['username']);
        $user->setProfilePicture($review['user_picture']);

        return new Review($review['comment'], $review['bathroomId'], $user);
    }

    public static function listAll(): array{
        $conn = MySQL::connect();
        $sql = "SELECT r.reviewId AS reviewId, b.comment AS comment, 
                b.bathroomId AS bathroomId, 
                u.email AS user_email, u.username AS username, u.profilePicture AS user_picture 
                FROM reviews r
                JOIN users u ON u.userId=r.userId
                JOIN bathrooms b ON b.bathroomId = r.bathroomId";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        $reviews = [];
        foreach($results as $result){
            $user = new User($result['email'], $result['username']);
            $user->setProfilePicture($result['user_picture']);

            $review = new Review($result['comment'], $result['bathroomId'], $result['user']);
            $review->reviewId = $result['reviewId'];
            $reviews[] = $review;
        }
        return $reviews;
    }

    public function getReviewId(): int{
        return $this->reviewId;
    } 
    public function getComment(): string{
        return $this->comment;
    }
    public function getBathroomId(): int{
        return $this->bathroomId;
    }
    public function getUser(): User{
        return $this->user;
    }
    
    public function setReviewId(int $reviewId): void{
        $this->reviewId = $reviewId;
    }
}