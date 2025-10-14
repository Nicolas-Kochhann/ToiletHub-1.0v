<?php

namespace Tests\Unit;

require_once __DIR__."../../vendor/autoload.php";

use PHPUnit\Framework\TestCase;

declare(strict_types=1);
use Src\Models\User;

final class UserTest extends TestCase {
     
     public function testInvalidSetPassword(): void{
        $u = new User("luiz@gmail.com" , "luiz");
        $u->setPassword('123');
        $this->assertSame(false, $u->getPassword());
     }

    public function testValidSetPassword(): void{
        $u = new User("luiz@gmail.com" , "luiz");
        $u->setPassword('Vi@!9fz');
        $this->assertSame(true, $u->getPassword());
     }

     public function testValidSetUsername(): void{
        
     }
        
        

    
}