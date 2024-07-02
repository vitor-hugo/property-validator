<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Strings;

use Attribute;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsString;
use Torugo\TString\Traits\Validators\TStringIsCnpj;

/**
 * Validates if a property has a valid CNPJ registration.
 *
 * The Brazil National Registry of Legal Entities number (CNPJ) is a company identification number
 * that must be obtained from the Department of Federal Revenue(Secretaria da Receita Federal do Brasil)
 * prior to the start of any business activities.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsCnpj extends IsString
{
    use TStringIsCnpj {
        isCnpj as protected validateCnpj;
    }

    public function validation(mixed $value): void
    {
        parent::validation($value);

        if (self::validateCnpj($value) == false) {
            $this->throwValidationException("The CNPJ '$value' is not valid.");
        }
    }
}
