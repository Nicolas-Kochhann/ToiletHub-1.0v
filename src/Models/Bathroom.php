<?php

namespace Src\Models;

use Src\Database\MySQL;
use Src\Interfaces\ActiveRecord;
use Src\Exceptions\Domain\BathroomNotFoundException;

class Bathroom implements ActiveRecord{
    private int $bathroomId;
    private string $description;
    private bool $isPaid;
    private int $price;
    private int $lat;
    private int $lon;
    private array $images;
    private User $owner;
    

    public function __construct(string $description, bool $isPaid, int $price, int $lat, int $lon, User $owner){
        $this->price = $price;
        $this->lat = $lat;
        $this->lon = $lon;
        $this->owner = $owner;
        $this->description = $description;
        $this->isPaid = $isPaid;
    }

    public static function saveImage(int $bathroomId, array $images): void{
        $conn = MySQL::connect();
        $sql = 'INSERT INTO bathrooms_images (image, bathroomId) VALUES (:image, :bathroomId)';
        $stmt = $conn->prepare($sql);
        foreach($images as $image){
            $stmt->execute([
                'image' => $image,
                'bathroomId' => $bathroomId
            ]);
        }
    }

    public static function findBathroomImages(int $bathroomId): array{
        $conn = MySQL::connect();
        $sql = 'SELECT image FROM bathrooms_images WHERE bathroomId=:bathroomId';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'bathroomId' => $bathroomId
        ]);
        $results = $stmt->fetchAll();
        $images = [];

        if(!$results){
            
        }

        foreach ($results as $result) {
            $images[] = $result['image'];
        }

        return $images;
    }

    public static function deleteImage(int $bathroomId, string $image): void{
        $conn = MySQL::connect();
        $sql = 'DELETE * FROM bathrooms_images WHERE image=:image AND bathroomId=:bathroomId';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'image' => $image,
            'bathroomId' => $bathroomId
        ]);
    }

    public function save(): bool{
        $conn = MySQL::connect();
        if($this->bathroomId){
            $sql = "UPDATE bathrooms SET description=:description isPaid=:isPaid, price=:price, lat=:lat, lon=:lon WHERE bathroomId=:bathroomId";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'description' => $this->description,
                'isPaid' => $this->isPaid,
                'price' => $this->price,
                'lat' => $this->lat,
                'lon' => $this->lon,
            ]);
        } else {
            $sql = "INSERT INTO bathrooms(description, isPaid, price, lat, lon, ownerId) VALUES(:description, :isPaid, :price, :lat, :lon, :ownerId)";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'description' => $this->description,
                'isPaid' => $this->isPaid,
                'price' => $this->price,
                'lat' => $this->lat,
                'lon' => $this->lon,
                'ownerId' => $this->owner->getUserId()
            ]);
        }
        return $result;
    }

    public function delete(): bool{
        $conn = MySQL::connect();
        $sql = "DELETE FROM bathrooms WHERE bathroomId=:bathroomId";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['bathroomId' => $this->bathroomId]);
        return $result;
    }

    public static function find($bathroomId): Bathroom{
        $conn = MySQL::connect();
        $sql = "SELECT b.isPaid AS isPaid, b.price AS price, b.lat AS lat, b.lon AS lon, 
                u.username AS owner_username, u.email AS owner_email, u.profilePicture as owner_picture 
                FROM bathrooms b
                JOIN user u ON u.userId=b.ownerId WHERE b.bathroomId=:bathroomId";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['bathroomId' => $bathroomId]);
        $result = $stmt->fetch();

        if(!$result){
            throw new BathroomNotFoundException();
        }

        $owner = new User($result['owner_email'], $result['owner_username']);
        $owner->setProfilePicture($result['owner_picture']);

        $bathroom = new Bathroom($result['description'], $result['isPaid'],$result['price'],$result['lat'],$result['lon'],$owner);
        $bathroom->bathroomId = $result['bathroomId'];
        $bathroom->images = Bathroom::findBathroomImages($bathroom->bathroomId);
        return $bathroom;
    }

    public static function listAll(): array{
        $conn = MySQL::connect();
        $sql = "SELECT b.bathroomId AS bathroomId, b.description AS description, b.isPaid AS isPaid, b.price AS price, b.lat AS lat, b.lon AS lon, 
                u.username AS owner_username, u.email AS owner_email, u.profilePicture as owner_picture 
                FROM bathrooms b
                JOIN user u ON u.userId=b.ownerId";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        $bathrooms = [];
        foreach($results as $result){
            $owner = new User($result['owner_email'], $result['owner_username']);
            $owner->setProfilePicture($result['owner_picture']);

            $bathroom = new Bathroom($result['description'], $result['isPaid'],$result['price'],$result['lat'],$result['lon'],$owner);
            $bathroom->bathroomId = $result['bathroomId'];
            $bathroom->images = Bathroom::findBathroomImages($bathroom->bathroomId);
            $bathrooms[] = $bathroom;
        }
        return $bathrooms;
    }

    public function getBathroomId(): int{
        return $this->bathroomId;
    }
    public function getDescription(): string{
        return $this->description;
    }
    public function getIsPaid(): bool{
        return $this->isPaid;
    }   
    public function getPrice(): int{
        return $this->price;
    }   
    public function getLat(): int{
        return $this->lat;
    }
    public function getlon(): int{
        return $this->lon;
    }
    public function getOwner(): User{
        return $this->owner;
    }

    public function setBathroomId(int $bathroomId): void{
        $this->bathroomId = $bathroomId;
    }
}