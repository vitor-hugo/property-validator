<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Common;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;

/**
 * Defines a property as required, therefore it is not nullable
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsRequired extends Validator
{
    public function validation(mixed $value): void
    {
        $isOptional = $this->property->getAttributes(IsOptional::class);

        if ($isOptional) {
            $this->throwValidationException("The property '{$this->propertyName}' cannot be REQUIRED and OPTIONAL at the same time.", 1);
        }

        if ($this->isNullable() && $this->propertyType !== 'mixed') {
            $this->throwValidationException("The property '{$this->propertyName}' cannot be REQUIRED and NULLABLE at the same time.", 2);
        }

        if ($this->isValueEmpty($value)) {
            $this->throwValidationException("The property '{$this->propertyName}' is required.'");
        }
    }
}
