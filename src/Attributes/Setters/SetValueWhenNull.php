<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Setters;

use Attribute;
use Torugo\PropertyValidator\Abstract\Setter;

/**
 * Sets a custom value when property receives a null value.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class SetValueWhenNull extends Setter
{
    /**
     * @param mixed $value The value to be setted when property receives null.
     */
    public function __construct(private mixed $value)
    {
    }

    public function setter(): void
    {
        $valueType = $this->getType($this->value);
        $this->expectPropertyTypeToBe(["mixed", $valueType]);

        if (is_null($this->propertyValue)) {
            $this->setValue($this->value);
        }
    }
}
