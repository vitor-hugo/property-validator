<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Common;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Common\Contracts\InvalidIsOptionalContract1;
use Tests\Integration\Validators\Common\Contracts\InvalidIsOptionalContract2;
use Tests\Integration\Validators\Common\Contracts\ValidIsOptionalContract;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Validators")]
#[Group("Common")]
#[Group("IsOptional")]
#[TestDox("IsOptional Validator")]
class IsOptionalTest extends TestCase
{
    #[TestDox("Optional properties should be valid")]
    public function testShouldBeValid()
    {
        $stub = new ValidIsOptionalContract;
        $stub->validate();
        $this->assertEquals(null, $stub->string);
        $this->assertEquals([], $stub->array);
        $this->assertEquals(null, $stub->mixed);
    }


    #[TestDox("Should be invalid when the property is not nullable")]
    public function testShouldBeInvalidWhenThePropertyIsNotNullable()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Property 'name' must be nullable.");
        $stub = new InvalidIsOptionalContract1;
        $stub->validate();
    }


    #[TestDox('Should be invalid when the property is defined as required')]
    public function testShouldBeInvalidWhenThePropertyIsRequired()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'name' can't use 'IsOptional' and 'IsRequired' side by side.");
        $stub = new InvalidIsOptionalContract2;
        $stub->validate();
    }
}
