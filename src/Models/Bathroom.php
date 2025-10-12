<?php

namespace Src\Models;

use Src\Database\MySQL;
use Src\Interfaces\ActiveRecord;
use BathroomNotFoundException;

class Bathroom implements ActiveRecord{
    private int $bathroomId;
    private string $description;
    private bool $isPaid;
    private int $price;
    private int $lat;
    private int $long;
    private array $images;
    private User $owner;
    

    public function __construct(string $description, bool $isPaid, int $price, int $lat, int $long, array $images = [], User $owner){
        $this->price = $price;
        $this->lat = $lat;
        $this->long = $long;
        $this->owner = $owner;
        $this->description = $description;
        $this->isPaid = $isPaid;
        $this->images = $images;
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

    public static function findBathroomImages($bathroomId): array{
        $conn = MySQL::connect();
        $sql = 'SELECT image FROM bathrooms_images WHERE bathroomId=:bathroomId';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'bathroomId' => $bathroomId
        ]);
        $results = $stmt->fetchAll();
        $images = [];

        foreach ($results as $result) {
            $images[] = $result['image'];
        }

        return $images;
    }

    public function save(): bool{
        $conn = MySQL::connect();
        if($this->bathroomId){
            $sql = "UPDATE bathrooms SET description=:description isPaid=:isPaid, price=:price, lat=:lat, long=:long WHERE bathroomId=:bathroomId";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'description' => $this->description,
                'isPaid' => $this->isPaid,
                'price' => $this->price,
                'lat' => $this->lat,
                'long' => $this->long,
            ]);
        } else {
            $sql = "INSERT INTO bathrooms(description, isPaid, price, lat, long, ownerId) VALUES(:description, :isPaid, :price, :lat, :long, :ownerId)";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'description' => $this->description,
                'isPaid' => $this->isPaid,
                'price' => $this->price,
                'lat' => $this->lat,
                'long' => $this->long,
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
        $sql = "SELECT b.isPaid AS isPaid, b.price AS price, b.lat AS lat, b.long AS long, 
                u.username AS owner_username, u.email AS owner_email, u.profilePicture as owner_picture 
                FROM bathrooms b
                JOIN user u ON u.userId=b.ownerId WHERE b.bathroomId=:bathroomId";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['bathroomId' => $bathroomId]);
        $bathroom = $stmt->fetch();

        if(!$bathroom){
            throw new BathroomNotFoundException();
        }

        $owner = new User($bathroom['owner_email'], $bathroom['owner_username']);
        $owner->setProfilePicture($bathroom['owner_picture']);

        $images = Bathroom::findBathroomImages($bathroomId);

        return new Bathroom($bathroom['isPaid'], $bathroom['price'],$bathroom['lat'],$bathroom['long'], $images, $owner);
    }

    public static function listAll(): array{
        $conn = MySQL::connect();
        $sql = "SELECT b.isPaid AS isPaid, b.price AS price, b.lat AS lat, b.long AS long, 
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

            $bathroom = new Bathroom($result['isPaid'], $result['price'],$result['lat'],$result['long'],$owner);
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
    public function getLong(): int{
        return $this->long;
    }
    public function getOwner(): User{
        return $this->owner;
    }

    public function setBathroomId(int $bathroomId): void{
        $this->bathroomId = $bathroomId;
    }
}