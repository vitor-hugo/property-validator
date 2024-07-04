<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Strings;

use Attribute;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsString;
use Torugo\TString\Traits\Validators\TStringIsSemVer;

/**
 * Validates whether a version number follow the rules of semantic versioning [(SemVer)](https://semver.org).
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsSemVer extends IsString
{
    use TStringIsSemVer;

    public function validation(mixed $value): void
    {
        parent::validation($value);

        if (self::isSemVer($value) == false) {
            $this->throwValidationException("The email '$value' is not valid.");
        }
    }
}
