<?php declare(strict_types=1);

namespace Tests\Integration;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Contracts\StubValidation;
use Torugo\PropertyValidator\Attributes\Validators\Common\IsOptional;
use Torugo\PropertyValidator\Attributes\Validators\Common\IsRequired;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;

class ValidOptionalClass extends StubValidation
{
    #[IsOptional()]
    public mixed $optional;

    public ?string $alsoOptional;
}

class InvalidOptionalClass1 extends StubValidation
{
    #[IsOptional()]
    public string $name = "My Name";
}

class InvalidOptionalClass2 extends StubValidation
{
    #[IsOptional()]
    #[IsRequired()]
    public mixed $name = "My Name";
}

#[Group('Validators')]
#[Group('Common')]
#[TestDox('IsOptional Validator')]
class OptionalTest extends TestCase
{
    private $validStub;

    public function setUp(): void
    {
        $this->validStub = new ValidOptionalClass();
    }


    public function testShouldBeValid()
    {
        $this->validStub->optional = null;
        $this->validStub->alsoOptional = null;
        $this->validStub->validate();
        $this->assertNull($this->validStub->optional);
        $this->assertNull($this->validStub->alsoOptional);

        $this->validStub->optional = 0;
        $this->validStub->alsoOptional = "";
        $this->validStub->validate();
        $this->assertEquals(0, $this->validStub->optional);
        $this->assertEquals("", $this->validStub->alsoOptional);

        $this->validStub->optional = false;
        $this->validStub->alsoOptional = "0";
        $this->validStub->validate();
        $this->assertEquals(false, $this->validStub->optional);
        $this->assertEquals("0", $this->validStub->alsoOptional);
    }


    #[TestDox('Should be invalid when the property is not nullable')]
    public function testShouldBeInvalidWhenThePropertyIsNotNullable()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("The property 'name' is defined as optional but is not nullable. Optional properties must be nullable.");
        $stub = new InvalidOptionalClass1();
        $stub->validate();
    }

    #[TestDox('Should be invalid when the property is defined as required')]
    public function testShouldBeInvalidWhenThePropertyIsRequired()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The property 'name' cannot be REQUIRED and OPTIONAL at the same time.");
        $stub = new InvalidOptionalClass2();
        $stub->validate();
    }
}
