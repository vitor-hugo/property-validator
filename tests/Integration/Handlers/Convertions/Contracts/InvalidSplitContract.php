<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Convertions\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Handlers\Convertions\Split;

class InvalidSplitContract extends BaseValidationTestClass
{
    #[Split(" ")]
    public string $lipsum = "Ut rutrum mauris eget pulvinar";

}
