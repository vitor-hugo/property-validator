<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Strings;

use Attribute;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsString;
use Torugo\TString\Traits\Validators\TStringIsCpf;

/**
 * Validates if a property has a valid CPF identification.
 *
 * CPF Stands for “Cadastro de Pessoas Físicas” or “Registry of Individuals”.
 * It is similar to the “Social Security” number adopted in the US, and it is used as a type
 * of universal identifier in Brazil.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsCpf extends IsString
{
    use TStringIsCpf;

    public function validation(mixed $value): void
    {
        parent::validation($value);

        if (self::IsCpf($value) == false) {
            $this->throwValidationException("The CPF '$value' is not valid.");
        }
    }
}
