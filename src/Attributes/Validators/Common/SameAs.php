<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Common;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;
use Torugo\PropertyValidator\Exceptions\ValidationException;

/**
 * Validates whether the value of a property is the same as another in the same class.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class SameAs extends Validator
{
    public function __construct(
        private string $target,
        string|null $errorMessage = null
    ) {
        parent::__construct($errorMessage);
    }

    public function validation(mixed $value): void
    {
        if (!property_exists($this->class, $this->target)) {
            $className = $this->getClassName($this->class::class);
            throw new ValidationException("Property '{$this->target}' does not exist on '$className' class.");
        }

        $targetValue = $this->class->{$this->target};

        if ($value !== $targetValue) {
            $this->throwValidationException("The value of '{$this->propertyName}' is different from '{$this->target}'.");
        }
    }
}
