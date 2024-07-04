<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Convertions\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Handlers\Convertions\Join;

class InvalidJoinContract extends BaseValidationTestClass
{
    #[Join()]
    public array $alpha = ["A", "B", "C", "D", "E", "F"];
}
