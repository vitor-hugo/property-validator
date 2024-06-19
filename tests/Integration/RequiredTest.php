<?php declare(strict_types=1);

namespace Tests\Integration;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Contracts\StubValidation;
use Torugo\PropertyValidator\Attributes\Validators\Common\IsRequired;
use Torugo\PropertyValidator\Exceptions\ValidationException;

class ValidRequiredClass extends StubValidation
{
    #[IsRequired()]
    public mixed $required;

    #[IsRequired()]
    public string $alsoRequired;
}

#[Group('Validators')]
#[Group('Common')]
#[TestDox('IsRequired Validator')]
class RequiredTest extends TestCase
{
    public function testShouldBeValid()
    {
        $stub = new ValidRequiredClass;
        $stub->required = ['array'];
        $stub->alsoRequired = 'My String';
        $stub->validate();
        $this->assertEquals(['array'], $stub->required);
        $this->assertEquals('My String', $stub->alsoRequired);
    }

    #[TestDox('Should throw ValidationException when required property is empty')]
    public function testShouldThrowWhenRequiredIsEmpty()
    {
        $this->expectException(ValidationException::class);
        $stub = new ValidRequiredClass;
        $stub->alsoRequired = '';
        $stub->validate();
    }

    #[TestDox('Should throw ValidationException when required property is NULL')]
    public function testShouldThrowWhenRequiredIsNull()
    {
        $this->expectException(ValidationException::class);
        $stub = new ValidRequiredClass;
        $stub->required = null;
        $stub->validate();
    }
}
