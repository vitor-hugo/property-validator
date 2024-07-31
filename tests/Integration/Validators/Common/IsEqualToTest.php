<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Common;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Common\Contracts\ValidIsEqualToContract;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Validators")]
#[Group("Common")]
#[Group("IsEqualTo")]
#[TestDox("IsEqualTo Validator")]
class IsEqualToTest extends TestCase
{
    #[TestDox("Should be valid")]
    public function testShouldBeValid()
    {
        $stub = new ValidIsEqualToContract;
        $this->assertTrue($stub->validate());
    }

    #[TestDox("Should throw ValidationException when value is not the expected")]
    public function testShouldThrowWhenValueIsNotExpected()
    {
        $values = [
            "string" => "strin",
            "array" => ["A", "B", "C", "D"],
            "bool" => true,
            "int" => 511,
            "float" => 3.14,
            "mixed" => "1014",
        ];

        foreach ($values as $prop => $value) {
            $stub = new ValidIsEqualToContract;
            $stub->{$prop} = $value;

            try {
                $stub->validate();
            } catch (\Throwable $th) {
                $this->assertInstanceOf(ValidationException::class, $th);
                $this->assertEquals("Invalid value for '$prop'.", $th->getMessage());
            }
        }
    }
}
