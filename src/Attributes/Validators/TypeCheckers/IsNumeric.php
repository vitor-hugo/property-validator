<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\TypeCheckers;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;
use Torugo\TString\Traits\Validators\TStringIsNumeric;

/**
 * Validates whether the value of a property is numeric.
 * Only float, int or numeric string types are allowed.
 * Requires the property to be set to `mixed`
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsNumeric extends Validator
{
    use TStringIsNumeric;

    public function validation(mixed $value): void
    {
        $this->expectPropertyTypeToBe(["int", "float", "string", "mixed"]);
        $this->expectValueTypeToBe(["int", "float", "string"]);

        $type = $this->getType($value);

        if ($type === "float" || $type === "int") {
            return;
        }

        if (self::isNumeric($value, true) === false) {
            $this->throwValidationException("'$value' on '{$this->propertyName}' is not a valid numeric value.");
        }
    }
}
