<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Handlers\Strings\ToTitleCase;

class ValidToTitleCaseContract extends BaseValidationTestClass
{
    #[ToTitleCase(false, false)]
    public mixed $default = "";

    #[ToTitleCase(true, false)]
    public mixed $roman = "";

    #[ToTitleCase(false, true)]
    public mixed $prep = "";

    #[ToTitleCase(true, true)]
    public mixed $both = "";
}
