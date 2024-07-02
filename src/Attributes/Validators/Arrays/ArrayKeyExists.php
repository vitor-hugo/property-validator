<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Arrays;

use Attribute;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsArray;

/**
 * Validates whether an array has one or more keys
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class ArrayKeyExists extends IsArray
{
    /**
     * @param mixed[] $keys Keys that must be present in the array.
     * @param bool $caseSensitive The search for keys should or should not be case sensitive. (Default true)
     * @param string|null $errorMessage Custom error message.
     */
    public function __construct(
        private array $keys,
        private bool $caseSensitive = true,
        string|null $errorMessage = null
    ) {
        parent::__construct($errorMessage);
    }


    public function validation(mixed $value): void
    {
        parent::validation($value);

        $valueKeys = array_keys($value);
        $keys = $this->keys;

        if ($this->caseSensitive == false) {
            $valueKeys = array_map('mb_strtolower', $valueKeys);
            $keys = array_map('mb_strtolower', $keys);
        }

        foreach ($keys as $index => $key) {
            if (!in_array($key, $valueKeys)) {
                $this->throwValidationException("Key '{$this->keys[$index]}' not found on '{$this->propertyName}'.");
            }
        }
    }
}
