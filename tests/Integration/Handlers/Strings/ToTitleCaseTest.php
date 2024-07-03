<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Handlers\Strings\Contracts\ValidToTitleCaseContract;

#[Group("Handlers")]
#[Group("Strings")]
#[Group("ToTitleCase")]
#[TestDox("ToTitleCase(): Handler")]
class ToTitleCaseTest extends TestCase
{
    public ValidToTitleCaseContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidToTitleCaseContract;
    }


    #[TestDox("Should convert default options")]
    public function testDefaultOptions()
    {
        $items = [
            "ADA LOVELACE" => "Ada Lovelace",
            "NISE DA SILVEIRA" => "Nise Da Silveira",
            "Tarsila Do Amaral" => "Tarsila Do Amaral",
            "albert einstein" => "Albert Einstein",
            "pope benedict xvi" => "Pope Benedict Xvi",
            "XV DE PIRACICABA" => "Xv De Piracicaba"
        ];

        foreach ($items as $from => $to) {
            $this->stub->default = $from;
            $this->assertTrue($this->stub->validate());
            $this->assertEquals($to, $this->stub->default);
        }
    }


    #[TestDox("Should convert with fixRomanNumerals enabled")]
    public function testFixRomanNumeral()
    {
        $items = [
            "ADA LOVELACE" => "Ada Lovelace",
            "NISE DA SILVEIRA" => "Nise Da Silveira",
            "Tarsila Do Amaral" => "Tarsila Do Amaral",
            "albert einstein" => "Albert Einstein",
            "pope benedict xvi" => "Pope Benedict XVI",
            "XV DE PIRACICABA" => "XV De Piracicaba"
        ];

        foreach ($items as $from => $to) {
            $this->stub->roman = $from;
            $this->assertTrue($this->stub->validate());
            $this->assertEquals($to, $this->stub->roman);
        }
    }


    #[TestDox("Should convert with fixPortuguesePrepositions enabled")]
    public function testFixPortPrep()
    {
        $items = [
            "ADA LOVELACE" => "Ada Lovelace",
            "NISE DA SILVEIRA" => "Nise da Silveira",
            "Tarsila Do Amaral" => "Tarsila do Amaral",
            "albert einstein" => "Albert Einstein",
            "pope benedict xvi" => "Pope Benedict Xvi",
            "XV DE PIRACICABA" => "Xv de Piracicaba"
        ];

        foreach ($items as $from => $to) {
            $this->stub->prep = $from;
            $this->assertTrue($this->stub->validate());
            $this->assertEquals($to, $this->stub->prep);
        }
    }


    #[TestDox("Should convert with both options enabled")]
    public function testFixBoth()
    {
        $items = [
            "ADA LOVELACE" => "Ada Lovelace",
            "NISE DA SILVEIRA" => "Nise da Silveira",
            "Tarsila Do Amaral" => "Tarsila do Amaral",
            "albert einstein" => "Albert Einstein",
            "pope benedict xvi" => "Pope Benedict XVI",
            "XV DE PIRACICABA" => "XV de Piracicaba"
        ];

        foreach ($items as $from => $to) {
            $this->stub->both = $from;
            $this->assertTrue($this->stub->validate());
            $this->assertEquals($to, $this->stub->both);
        }
    }


    #[TestDox("Should convert string elements in array")]
    public function testConvertInArray()
    {
        $input = [
            "programmer" => "ADA LOVELACE",
            "writers" => [
                "NISE DA SILVEIRA",
                "Tarsila Do Amaral",
            ],
            "roman" => [
                "pope benedict xvi",
                "XV DE PIRACICABA"
            ]
        ];

        $expected = [
            "programmer" => "Ada Lovelace",
            "writers" => [
                "Nise da Silveira",
                "Tarsila do Amaral"
            ],
            "roman" => [
                "Pope Benedict XVI",
                "XV de Piracicaba"
            ]
        ];

        $this->stub->both = $input;
        $this->assertTrue($this->stub->validate());
        $this->assertSame($expected, $this->stub->both);
    }
}
