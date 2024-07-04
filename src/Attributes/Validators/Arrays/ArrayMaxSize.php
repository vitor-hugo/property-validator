<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Arrays;

use Attribute;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsArray;
use Torugo\PropertyValidator\Exceptions\ValidationException;

/**
 * Checks whether the number of elements in an array
 * is less than or equal to a specified number.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class ArrayMaxSize extends IsArray
{
    /**
     * @param int $max Maximum accepted elements. Must be >= 1.
     * @param string|null $errorMessage custom error message.
     */
    public function __construct(
        private int $max,
        string|null $errorMessage = null
    ) {
        parent::__construct($errorMessage);
    }


    public function validation(mixed $value): void
    {
        parent::validation($value);

        if ($this->max < 1) {
            throw new ValidationException("ArrayMaxSize: the max argument must be >= 1.");
        }

        $count = count($value);
        if ($count > $this->max) {
            $this->throwValidationException("The number of elements on '{$this->propertyName}' should be <= {$this->max}, $count received.");
        }
    }
}
