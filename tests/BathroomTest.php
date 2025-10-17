<?php
declare(strict_types=1);

namespace Tests\Unit;

require_once __DIR__."/../vendor/autoload.php";


use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Depends;

use Src\Database\MySQL;
use Src\Exceptions\Domain\BathroomNotFoundException;
use Src\Models\User;
use Src\Models\Bathroom;

final class BathroomTest extends TestCase {
   
     public function testBathroomCRUDMethods(): void{
         $u = new User('vojoja@gmail.com', 'Marcelo');
         $u->setPassword('Vi@!9fz');
         $result = $u->save();
         
         $pdo = MySQL::connect();
         $lastUserId = (int)$pdo->lastInsertId();

         $u->setUserId($lastUserId);

         $b = new Bathroom('Toilet on Pompeii', false, null, 58.5583, -29.8158, $u);
         $result = $b->save();
         $this->assertSame(true, $result);

         $lastBathroomId = (int)$pdo->lastInsertId();

         $b1 = new Bathroom('Toilet on Rome', false, null, 58.5583, -29.8158, $u);
         $b1->setBathroomId($lastBathroomId);
         $result = $b1->save();
         $this->assertSame(true, $result);

         $b2 = Bathroom::find($lastBathroomId);
         $this->assertSame('Toilet on Rome', $b2->getDescription());
         $this->assertSame(false, $b2->getIsPaid());
         $this->assertSame(null, $b2->getPrice());
         $this->assertSame(58.5583, $b2->getLat());
         $this->assertSame(-29.8158, $b2->getLon());
         $this->assertSame($lastUserId, $b2->getOwner()->getUserId());

         $array = [$b2];
         $result = Bathroom::listAll();
         $this->assertArrayIsEqualToArrayOnlyConsideringListOfKeys($array, $result, [0]);

         $result = Bathroom::delete($lastBathroomId);
         $this->assertSame(true, $result);

         User::delete($b2->getOwner()->getUserId());

         $this->expectException(BathroomNotFoundException::class);
         Bathroom::find($lastBathroomId);
     }

     #[Depends('testBathroomCRUDMethods')]
     public function testSaveFindAndDeleteImage(){
         $u = new User('vojoja@gmail.com', 'Marcelo');
         $u->setPassword('Vi@!9fz');
         $result = $u->save();
         
         $pdo = MySQL::connect();
         $lastUserId = (int)$pdo->lastInsertId();

         $u->setUserId($lastUserId);

         $b = new Bathroom('Toilet on Pompeii', false, null, 58.5583, -29.8158, $u);
         $b->save();
         $lastBathroomId = (int)$pdo->lastInsertId();
         
         $b->setBathroomId($lastBathroomId);
         
         $mock_images = ['picture1.jpg', 'picture2.jpg', 'picture3.jpg', 'picture4.jpg'];
         Bathroom::saveImage($b->getBathroomId(), $mock_images);

         $result = Bathroom::findBathroomImages($b->getBathroomId());
         $this->assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys($mock_images, $result, [0, 1, 2, 3]);

         Bathroom::deleteImage($b->getBathroomId(), 'picture1.jpg');
         Bathroom::deleteImage($b->getBathroomId(), 'picture2.jpg');
         Bathroom::deleteImage($b->getBathroomId(), 'picture3.jpg');
         Bathroom::deleteImage($b->getBathroomId(), 'picture4.jpg');

         $result = Bathroom::findBathroomImages($b->getBathroomId());
         $this->assertArrayNotHasKey(0, $result);

         Bathroom::delete($b->getBathroomId());
         User::delete($u->getUserId());
     }

}