<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Strings;

use Attribute;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsString;
use Torugo\TString\Traits\Validators\TStringContains;

/**
 * Validates whether a string is a valid [TUID](https://github.com/vitor-hugo/util-php?tab=readme-ov-file#tuid-torugo-unique-id).
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsTUID extends IsString
{
    private const PATTERN_SHORT = "/^[A-Z][A-Z0-9]{6}-TS[A-Z0-9]{10}$/";
    private const PATTERN_MEDIUM = "/^[A-Z][A-Z0-9]{7}-[A-Z0-9]{4}-TM[A-Z0-9]{10}$/";
    private const PATTERN_LONG = "/^[A-Z][A-Z0-9]{7}-[A-Z0-9]{4}-[A-Z0-9]{9}-TL[A-Z0-9]{10}$/";

    public function validation(mixed $value): void
    {
        parent::validation($value);

        $isValid = false;

        $pattern = match (strlen($value)) {
            20      => self::PATTERN_SHORT,
            26      => self::PATTERN_MEDIUM,
            36      => self::PATTERN_LONG,
            default => false,
        };

        if ($pattern == false) {
            $this->throwValidationException("Property '{$this->propertyName}' is not valid.");
        }

        $match = preg_match_all($pattern, $value);
        if ($match !== 1) {
            $this->throwValidationException("Property '{$this->propertyName}' is not valid.");
        }
    }
}
