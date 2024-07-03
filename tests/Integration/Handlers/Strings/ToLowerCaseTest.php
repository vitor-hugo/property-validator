<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Handlers\Strings\Contracts\ValidToLowerCaseContract;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;

#[Group("Handlers")]
#[Group("Strings")]
#[Group("ToLowerCase")]
#[TestDox("ToLowerCase(): Handler")]
class ToLowerCaseTest extends TestCase
{
    public ValidToLowerCaseContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidToLowerCaseContract;
    }


    #[TestDox("Should convert strings")]
    public function testShouldConvertStrings()
    {
        $items = [
            "ABCDEFGHIJKLMNOPQRSTUVWXYZ" => "abcdefghijklmnopqrstuvwxyz",
            "ÃÁÀÂÄÇÉÊËÍÏÕÓÔÖÚÜ" => "ãáàâäçéêëíïõóôöúü",
            "ΑΝΆΠΤΥΞΗ" => "ανάπτυξη",
            "MYEMAIL@GOOGLE.COM" => "myemail@google.com",
            "Ada Lovelace" => "ada lovelace"
        ];

        foreach ($items as $from => $to) {
            $this->stub->item = $from;
            $this->assertTrue($this->stub->validate());
            $this->assertEquals($to, $this->stub->item);
        }
    }


    #[TestDox("Should convert string elements of an array")]
    public function testShouldConvertStringElementsOfAnArray()
    {
        $input = [
            "NISE DA SILVEIRA",
            ["EMAIL@HOST.COM", "OTHER_EMAIL@HOST.COM"],
            ["A", ["B", ["C", ["D", ["E", "F"], 10], 20], "G"]],
        ];

        $expected = [
            "nise da silveira",
            ["email@host.com", "other_email@host.com"],
            ["a", ["b", ["c", ["d", ["e", "f"], 10], 20], "g"]],
        ];

        $this->stub->item = $input;
        $this->assertTrue($this->stub->validate());
        $this->assertSame($expected, $this->stub->item);
    }


    #[TestDox("Should throw InvalidTypeException on non strings")]
    public function testShouldThrowOnNonStrings()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("ToLowerCase only handles string and array values.");
        $this->stub->item = 1000;
        $this->stub->validate();
    }
}
