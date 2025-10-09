<?php

namespace Src\Models;

class Bathroom implements ActiveRecord{
    private int $bathroomId;
    private bool $isPaid;
    private int $price;
    private int $lat;
    private int $long;
    private User $owner;

    public function save(): bool{
        $conn = MySQL::connect();
        if($this->userId){
            $sql = "UPDATE bathrooms SET isPaid=:isPaid, price=:price, lat=:lat, long=:long, ownerId=:ownerId WHERE bathroomId=:bathroomId";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'isPaid' => $this->isPaid,
                'price' => $this->price,
                'lat' => $this->lat,
                'long' => $this->long,
                'ownerId' => $this->owner
            ]);
        } else {
            $sql = "INSERT INTO bathrooms(isPaid, price, lat, long, ownerId) VALUES(:isPaid, :price, :lat, :long, :ownerId)";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'isPaid' => $this->isPaid,
                'price' => $this->price,
                'lat' => $this->lat,
                'long' => $this->long
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
        $sql = "SELECT isPaid, price, lat, long, ownerId FROM bathrooms WHERE bathroomId=:bathroomId";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['bathroomId' => $bathroomId]);
        $bathroom = $stmt->fetch();

        return new Bathroom($bathroom['isPaid'], $bathroom['price'],$bathroom['lat'],$bathroom['long'],$bathroom['ownerId']);
    }

    public static function listAll(): array{
        $conn = MySQL::connect();
        $sql = "SELECT isPaid, price, lat, long, ownerId FROM bathrooms";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        $bathroomss = [];
        foreach($results as $result){
            $bathroom = new Bathroom($result['isPaid'], $result['price'],$result['lat'],$result['long'],$result['ownerId'],);
            $bathrooms[] = $bathroom;
        }
        return $users;
    }
}