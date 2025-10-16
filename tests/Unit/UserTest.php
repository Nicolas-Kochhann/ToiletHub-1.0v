<?php
declare(strict_types=1);

namespace Tests\Unit;

require_once __DIR__."/../../vendor/autoload.php";


use PDOStatement;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Depends;

use Src\Database\MySQL;
use Src\Exceptions\Domain\InvalidEmailException;
use Src\Exceptions\Domain\InvalidPasswordException;
use Src\Exceptions\Domain\UserNotFoundException;
use Src\Models\User;

final class UserTest extends TestCase {
     
   public function testValidatePasswordWithInvalidPassword(): void{
      $result = User::validatePassword('123');
      $this->assertSame(false, $result);
   }

   public function testValidatePasswordWithValidPassword(): void{
      $result = User::validatePassword('Vi@!9fz');
      $this->assertSame(true, $result);
   }

   #[Depends('testValidatePasswordWithInvalidPassword')]
   public function testInvalidPasswordException(): void{
      $this->expectException(InvalidPasswordException::class);
      $u = new User("luiz@gmail.com" , "luiz");
      $u->setPassword('V123');
      $u->save();
   }

   public function testValidateEmailWithInvalidEmail(): void{
      $result = User::validateEmail('vojoja.com');
      $this->assertSame(false, $result);
   }

   public function testValidateEmailWithValidEmail(): void{
      $result = User::validateEmail('vojoja@gmail.com');
      $this->assertSame(true, $result);
   }

     public function testInvalidEmailException(): void{
         $this->expectException(InvalidEmailException::class);
         $u = new User('vojoja.com', 'marcelo');
         $u->save();
     }

     public function testUserCRUDMethods(): void{
         $u = new User('vojoja@gmail.com', 'Marcelo');
         $u->setPassword('Vi@!9fz');
         $result = $u->save();
         $this->assertSame(true, $result);

         $pdo = MySQL::connect();
         $lastId = (int)$pdo->lastInsertId();

         $r = new User('luiz@gmail.com', 'luiz');
         $r->setUserId($lastId);
         $result = $r->save();
         $this->assertSame(true, $result);

         $g = User::find($lastId);
         $this->assertSame('luiz@gmail.com', $g->getEmail());
         $this->assertSame('luiz', $g->getUsername());
         $this->assertSame(null, $g->getProfilePicture());

         $array = [$g];
         $result = User::listAll();
         $this->assertArrayIsEqualToArrayOnlyConsideringListOfKeys($array, $result, [0]);

         $result = User::delete($lastId);
         $this->assertSame(true, $result);
         $this->expectException(UserNotFoundException::class);
         User::find($lastId);
     }

     #[Depends('testUserCRUDMethods')]
     public function testAuthentication(): void{
         $u = new User('nicolas@gmail.com', 'nicolas');
         $u->setPassword('Vi@!9fz');
         $u->save();
         $pdo = MySQL::connect();
         $lastInsertId = (int)$pdo->lastInsertId();

         $result = User::authenticate('nicolas@gmail.com', 'Vi@!9fz');
         $this->assertSame(true, $result);
         
         $result = User::authenticate('nicolas@gmail.com', '1322VVVV');
         $this->assertSame(false, $result);
         
         User::delete($lastInsertId);
     }
     
}