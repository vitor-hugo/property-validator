<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Arrays;

use Attribute;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsArray;
use Torugo\PropertyValidator\Exceptions\ValidationException;

/**
 * Checks whether the number of elements in an array
 * is greater than or equal to a specified number.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class ArrayMinSize extends IsArray
{
    /**
     * @param int $min Minimum accepted elements. Must be >= 1.
     * @param string|null $errorMessage custom error message.
     */
    public function __construct(
        private int $min,
        string|null $errorMessage = null
    ) {
        parent::__construct($errorMessage);
    }


    public function validation(mixed $value): void
    {
        parent::validation($value);

        if ($this->min < 1) {
            throw new ValidationException("ArrayMinSize: The min argument must be >= 1.");
        }

        $count = count($value);
        if ($count < $this->min) {
            $this->throwValidationException("The number of elements on '{$this->propertyName}' should be >= {$this->min}, $count received.");
        }
    }
}
