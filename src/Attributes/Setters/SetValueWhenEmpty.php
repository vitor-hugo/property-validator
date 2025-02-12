<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Setters;

use Attribute;
use Torugo\PropertyValidator\Abstract\Setter;

/**
 * Sets a custom value when a string property receives an empty value ('').
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class SetValueWhenEmpty extends Setter
{
    /**
     * @param string $value The value to be setted when property receives an empty string or null.
     */
    public function __construct(private string $value)
    {
    }

    public function setter(): void
    {
        $this->expectPropertyTypeToBe(["mixed", "string"]);

        if (empty($this->propertyValue) || is_null($this->propertyValue)) {
            $this->setValue($this->value);
        }
    }
}
