<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Arrays;

use Attribute;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsArray;

/**
 * Validates whether an array contains a given value.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class ArrayContains extends IsArray
{
    /**
     * @param mixed $search The searched value. Note: If string, the comparison is done in a case-sensitive manner.
     * @param bool $strict The type of searched value should match. (Default: true).
     * @param string|null $errorMessage Custom error message.
     */
    public function __construct(
        private mixed $search,
        private bool $strict = true,
        string|null $errorMessage = null
    ) {
        parent::__construct($errorMessage);
    }


    public function validation(mixed $value): void
    {
        parent::validation($value);

        // TODO: Implement a case insensitive string search

        if (!in_array($this->search, $value, $this->strict)) {
            $searchType = $this->getType($this->search);

            if ($searchType === "array") {
                $search = "[" . implode(", ", $this->search) . "]";
            } else if ($searchType === "bool") {
                $search = $value ? "true" : "false";
            } else if ($searchType === "string") {
                $search = "'{$this->search}'";
            } else {
                $search = $this->search;
            }

            $this->throwValidationException("Property '{$this->propertyName}' does not contains $searchType($search).");
        }
    }
}
