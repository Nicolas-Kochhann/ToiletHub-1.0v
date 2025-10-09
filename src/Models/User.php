<?php

namespace Src\Models;

use Src\Database\MySQL;
use Src\Interfaces\ActiveRecord;
use UserNotFoundException;

class User implements ActiveRecord{
    private int $userId;
    private string $username;
    private string $profilePicture;
    private string $email;
    private string $password;

    public function __construct($email, $username){
        $this->username = $username;
        $this->email = $email;
    }

    public function getUserId(): int{
        return $this->userId;
    }
    public function getUsername(): string{
        return $this->username;
    } 
    public function getProfilePicture(): string{
        return $this->profilePicture;
    } 
    public function getEmail(): string{
        return $this->email;
    }
    public function getPassword(): string{
        return $this->password;
    }

    public function setUserId(int $userId): void{
        $this->userId = $userId;
    }
    public function setProfilePicture(string $profilePicture): void{
        $this->profilePicture = $profilePicture;
    }
    public function setPassword(string $password): void{
        $this->password = $password;
    }

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
        $result = $stmt->fetch();
        
        if(!$user){
            throw new UserNotFoundException();
        }

        $user = User($user['username'], $user['email']);
        $user->setProfilePicture($user['profilePicture']);
        return $user;
    }

    public static function listAll(): array{
        $conn = MySQL::connect();
        $sql = "SELECT username, profilePicture, email FROM users";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        $users = [];
        foreach($results as $result){
            $user = new User($result['username'], $result['email']);
            $user->setProfilePicture($result['profilePicture']);
            $users[] = $user;
        }
        return $users;
    }

    public static function authenticate($email, $password): bool{
        $conn = MySQL::connect();
        $sql = "SELECT password FROM users WHERE email=:email";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute();
        $passwordHash = $stmt->fetchColumn();
        return password_verify($password, $passwordHash);
    }
}