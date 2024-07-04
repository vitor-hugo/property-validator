<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Convertions\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Handlers\Convertions\Implode;
use Torugo\PropertyValidator\Attributes\Handlers\Convertions\Join;

class ValidJoinContract extends BaseValidationTestClass
{
    #[Join()]
    public $alpha = ["A", "B", "C", ["D", "E", "F"]];

    #[Join(".")]
    public $ip = ["123", "456", "789", "001"];

    #[Implode(" ")]
    public $name = ["firstName" => "Conceição", "lastName" => "Evaristo"];

    #[Join(" - ", true, ": ")]
    public $form = ["firstName" => "Conceição", "lastName" => "Evaristo"];
}
