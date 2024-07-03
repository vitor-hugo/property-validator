<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Handlers\Strings\Contracts\ValidToUpperCaseContract;

#[Group("Handlers")]
#[Group("Strings")]
#[Group("ToUpperCase")]
#[TestDox("ToUpperCase(): Handler")]
class ToUpperCaseTest extends TestCase
{
    public ValidToUpperCaseContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidToUpperCaseContract;
    }


    #[TestDox("Should convert strings")]
    public function testShouldConvertStrings()
    {
        $items = [
            "abcdefghijklmnopqrstuvwxyz" => "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
            "ãáàâäçéêëíïõóôöúü" => "ÃÁÀÂÄÇÉÊËÍÏÕÓÔÖÚÜ",
            "ανάπτυξη" => "ΑΝΆΠΤΥΞΗ",
            "myemail@google.com" => "MYEMAIL@GOOGLE.COM",
            "ada lovelace" => "ADA LOVELACE"
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
            "nise da silveira",
            ["email@host.com", "other_email@host.com"],
            ["a", ["b", ["c", ["d", ["e", "f"], 10], 20], "g"]],
        ];

        $expected = [
            "NISE DA SILVEIRA",
            ["EMAIL@HOST.COM", "OTHER_EMAIL@HOST.COM"],
            ["A", ["B", ["C", ["D", ["E", "F"], 10], 20], "G"]],
        ];

        $this->stub->item = $input;
        $this->assertTrue($this->stub->validate());
        $this->assertSame($expected, $this->stub->item);
    }


    #[TestDox("Should do nothing on non strings")]
    public function testShouldThrowOnNonStrings()
    {
        $this->stub->item = 98786;
        $this->assertTrue($this->stub->validate());
        $this->assertEquals(98786, $this->stub->item);
    }
}
