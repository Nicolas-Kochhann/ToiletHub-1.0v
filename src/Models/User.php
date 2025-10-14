<?php

namespace Src\Models;

use PDOException;

use Src\Database\MySQL;
use Src\Interfaces\ActiveRecord;
use Src\Exceptions\Domain\InvalidEmailException;
use Src\Exceptions\Domain\UserNotFoundException;
use Src\Exceptions\Domain\EmailAlreadyExistsException;

class User implements ActiveRecord{
    private int $userId;
    private string $username;
    private ?string $profilePicture;
    private string $email;
    private string $password;

    public function __construct($email, $username){
        $this->username = $username;
        $this->email = $email;
    }

    public static function authenticate($email, $password): bool{
        $conn = MySQL::connect();
        $sql = "SELECT userId, password FROM users WHERE email=:email";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'email' => $email
        ]);
        $result = $stmt->fetch();
        if(password_verify($password, $result['password'])){
            $session_user = User::find($result['userId']);
            session_start();
            $_SESSION['userId'] = $session_user->userId;
            $_SESSION['username'] = $session_user->username;
            $_SESSION['profilePicture'] = $session_user->profilePicture;
            return true;
        }
        return false;
    }

    public static function validateEmail($email): bool{
        return filter_var($email, FILTER_SANITIZE_EMAIL) and filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validatePassword($password): bool{
        $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/';
        $result = preg_match($regex, $password);
        return $result === 1;
    }


    public function save(): bool{
        $conn = MySQL::connect();
        if(!self::validateEmail($this->email)){
            throw new InvalidEmailException();
        }
        if(isset($this->userId)){
            $sql = "UPDATE Users SET username=:username, profilePicture=:profilePicture, email=:email WHERE userId=:userId";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'username' => $this->username,
                'profilePicture' => $this->profilePicture,
                'email' => $this->email,
                'userId' => $this->userId
            ]);
            return $result;
        } else {
            try {
                $sql = "INSERT INTO Users(username, email, password) VALUES(:username, :email, :password)";
                $stmt = $conn->prepare($sql);
                $result = $stmt->execute([
                    'username' => $this->username,
                    'email' => $this->email,
                    'password' => password_hash($this->password, PASSWORD_BCRYPT)
                ]);
                return $result;
            } catch (PDOException $e) {
                throw new EmailAlreadyExistsException("This email already exists!", 0, $e);   
            }
        }
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
        $sql = "SELECT userId, username, profilePicture, email FROM users WHERE userId=:userId";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['userId' => $userId]);
        $result = $stmt->fetchAll();
        
        if(!$result){
            throw new UserNotFoundException();
        }


        $user = new self($result['username'], $result['email']);
        $user->profilePicture = $result['profilePicture'];
        $user->userId = $result['userId'];
        return $user;
    }

    public static function listAll(): array{
        $conn = MySQL::connect();
        $sql = "SELECT userId, username, profilePicture, email FROM users";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        $users = [];
        foreach($results as $result){
            $user = new self($result['username'], $result['email']);
            $user->profilePicture = $result['profilePicture'];
            $user->userId = $result['userId'];
            $users[] = $user;
        }
        return $users;
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
        self::validatePassword($password);
        $this->password = $password;
    }

}