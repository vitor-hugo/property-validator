<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Handlers\Common;

use Attribute;
use InvalidArgumentException;
use Torugo\PropertyValidator\Abstract\Handler;

/**
 * Copies the value of another property in the same class.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class CopyFrom extends Handler
{
    /**
     * @param string $target Name of the property whose value will be copied.
     */
    public function __construct(private string $target)
    {
    }

    public function handler(mixed $_): void
    {
        if (!property_exists($this->class, $this->target)) {
            $className = $this->getClassName($this->class::class);
            throw new InvalidArgumentException("Property '{$this->target}' does not exist on '$className' class.");
        }

        $targetValue = $this->class->{$this->target};

        $targetValueType = $this->getType($targetValue);

        $this->expectPropertyTypeToBe(["mixed", $targetValueType]);

        $this->setValue($targetValue);
    }
}
