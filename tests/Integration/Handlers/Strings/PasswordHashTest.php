<?php declare(strict_types=1);

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Handlers\Strings\Contracts\ValidPasswordHashContract;

#[Group("Strings")]
#[Group("PasswordHash")]
#[TestDox("PasswordHash")]
class PasswordHashTest extends TestCase
{
    public ValidPasswordHashContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidPasswordHashContract;
    }


    #[TestDox("Should generate a hash from password")]
    public function testShouldBeValid()
    {
        $pw1 = "5up3rStr0ngP4ssw0rd!";
        $pw2 = "tKxSYVBH+Te2rb5nUWN87&";
        $pw3 = "LzM#KFSqk9Uwb7TQsYA3JW";

        $this->stub->pass1 = $pw1;
        $this->stub->pass2 = $pw2;
        $this->stub->pass3 = $pw3;

        $this->stub->validate();

        var_dump($this->stub->pass1);
        var_dump($this->stub->pass2);
        var_dump($this->stub->pass3);


        $this->assertTrue(password_verify($pw1, $this->stub->pass1));
        $this->assertTrue(password_verify($pw2, $this->stub->pass2));
        $this->assertTrue(password_verify($pw3, $this->stub->pass3));
    }
}
