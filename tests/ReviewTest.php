<?php
declare(strict_types=1);

namespace Tests\Unit;

require_once __DIR__."/../vendor/autoload.php";


use PHPUnit\Framework\TestCase;

use Src\Database\MySQL;
use Src\Exceptions\Domain\ReviewNotFoundException;
use Src\Models\Review;
use Src\Models\User;
use Src\Models\Bathroom;

final class ReviewTest extends TestCase {
   
     public function testBathroomCRUDMethods(): void{
         $u = new User('vojoja@gmail.com', 'Marcelo');
         $u->setPassword('Vi@!9fz');
         $result = $u->save();
         
         $pdo = MySQL::connect();
         $lastUserId = (int)$pdo->lastInsertId();

         $u->setUserId($lastUserId);

         $b = new Bathroom('Toilet on Rome', false, null, 58.5583, -29.8158, $u);
         $result = $b->save();
         $lastBathroomId = (int)$pdo->lastInsertId();

         $r = new Review('Best toilet in Rome', $lastBathroomId, $u);
         $result = $r->save();
         $this->assertSame(true, $result);

         $lastReviewId = (int)$pdo->lastInsertId();

         $r1 = new Review('The most beatiful toilet on Italy', $lastBathroomId, $u);
         $r1->setReviewId($lastReviewId);
         $result = $r1->save();
         $this->assertSame(true, $result);

         $r2 = Review::find($lastReviewId);
         $this->assertSame('The most beatiful toilet on Italy', $r2->getComment());
         $this->assertSame($lastBathroomId, $r2->getBathroomId());
         $this->assertSame($lastUserId, $r2->getUser()->getUserId());

         $array = [$r2];
         $result = Review::listAll();
         $this->assertArrayIsEqualToArrayOnlyConsideringListOfKeys($array, $result, [0]);

         $result = Review::delete($lastReviewId);
         $this->assertSame(true, $result);

         Bathroom::delete($r2->getBathroomId());

         User::delete($r2->getUser()->getUserId());

         $this->expectException(ReviewNotFoundException::class);
         Review::find($lastReviewId);
     }
}