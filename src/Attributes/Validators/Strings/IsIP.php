<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Strings;

use Attribute;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsString;
use Torugo\TString\Traits\Validators\TStringIsIP;

/**
 * Validates whether a string is a valid IP address V4 or V6.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsIP extends IsString
{
    use TStringIsIP;

    /**
     * @param int $version 4 or 6, otherwhise validates both
     * @param string|null $errorMessage Custom error message
     */
    public function __construct(
        private int $version = 0,
        string|null $errorMessage = null,
    ) {
        parent::__construct($errorMessage);
    }

    public function validation(mixed $value): void
    {
        parent::validation($value);

        if (self::isIP($value, $this->version) == false) {
            $this->throwValidationException("The IP address '$value' is not valid.");
        }
    }
}
