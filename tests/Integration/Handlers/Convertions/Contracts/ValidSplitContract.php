<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Convertions\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Handlers\Convertions\Explode;
use Torugo\PropertyValidator\Attributes\Handlers\Convertions\Split;

class ValidSplitContract extends BaseValidationTestClass
{
    #[Split(" ")]
    public $lipsum = "Ut rutrum mauris eget pulvinar";

    #[Split(".")]
    public $ip = "123.456.789.001";

    #[Split("-", 4)]
    public $serial = "lvnr-MHba-hb6G-Mezq-8I55-eyZv";

    #[Explode("-", -2)]
    public $str = "lvnr-MHba-hb6G-Mezq-8I55-eyZv";
}
