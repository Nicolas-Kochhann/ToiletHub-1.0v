<?php

namespace Src\Models;

use Src\Database\MySQL;
use Src\Interfaces\ActiveRecord;

class User implements ActiveRecord{
    private int $userId;
    private string $username;
    private string $profilePicture;
    private string $email;
    private string $password;

    public function save(): bool{
        $conn = MySQL::connect();
        if($this->userId){
            $sql = "UPDATE Users SET username=:username, profilePicture=:profilePicture, email=:email WHERE userId=:userId";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'username' => $this->username,
                'profilePicture' => $this->profilePicture,
                'email' => $this->email,
                'userId' => $this->userId
            ]);
        } else {
            $sql = "INSERT INTO Users(username, email, password) VALUES(:username, :email, :password)";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'username' => $this->username,
                'email' => $this->email,
                'password' => password_hash($this->password, PASSWORD_BCRYPT)
            ]);
        }
        return $result;
    }

    public function delete(): bool{
        $conn = MySQL::connect();
        $sql = "DELETE FROM users WHERE userId=:userId";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['userId' => $this->userId]);
        return $result;
    }

    public static function find($userId): User{
        $conn = MySQL::connect();
        $sql = "SELECT username, profilePicture, email FROM users WHERE userId=:userId";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['userId' => $userId]);
        $user = $stmt->fetch();
        return $user;
    }

    public static function listAll(): array{
        $conn = MySQL::connect();
        $sql = "SELECT username, profilePicture, email FROM users";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll();
        return $users;
    }
}