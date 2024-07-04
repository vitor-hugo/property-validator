<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Convertions;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Handlers\Convertions\Contracts\InvalidSplitContract;
use Tests\Integration\Handlers\Convertions\Contracts\ValidSplitContract;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;

#[Group("Convertion")]
#[Group("Split")]
#[Group("Explode")]
#[TestDox("Split")]
class SplitTest extends TestCase
{
    public ValidSplitContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidSplitContract;
    }

    #[TestDox("Should split/explode string into array of strings")]
    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
        $this->assertEquals(['Ut', 'rutrum', 'mauris', 'eget', 'pulvinar'], $this->stub->lipsum);
        $this->assertEquals(['123', '456', '789', '001'], $this->stub->ip);
    }


    #[TestDox("Should respect the limit argument")]
    public function test()
    {
        $this->assertTrue($this->stub->validate());
        $this->assertEquals(['lvnr', 'MHba', 'hb6G', 'Mezq-8I55-eyZv'], $this->stub->serial);
        $this->assertEquals(['lvnr', 'MHba', 'hb6G', 'Mezq'], $this->stub->str);
    }


    #[TestDox("Should throw InvalidTypeException when property is not mixed type")]
    public function testShouldThrowWhenPropIsNotMixedType()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Property 'lipsum' must be setted as mixed.");
        $stub = new InvalidSplitContract;
        $stub->validate();
    }
}
