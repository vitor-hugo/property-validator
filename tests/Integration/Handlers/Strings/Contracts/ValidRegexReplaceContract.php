<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Handlers\Strings\RegexReplace;

class ValidRegexReplaceContract extends BaseValidationTestClass
{
    #[RegexReplace("/\s{2,}/", " ")]
    public $doubleSpaces = "Should normalize  consecutive   spaces";

    #[RegexReplace("/[^0-9]/", "")]
    public string $onlyNumbers = "CPF: 123.456.789-10";

    #[RegexReplace("/([0-9]+)-([A-Z]+)/", "\\2-\\1")]
    public string $groups = "123-ABC";
}
