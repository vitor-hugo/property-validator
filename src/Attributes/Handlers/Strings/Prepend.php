<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Handlers\Strings;

use Attribute;
use Torugo\PropertyValidator\Abstract\Handler;

/**
 * Concatenates a string at the beginning of the property value.
 */
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class Prepend extends Handler
{
    /**
     * @param string $append String to be added
     */
    public function __construct(private string $prepend)
    {
    }


    public function handler(mixed $value): void
    {
        if (!$this->propertTypeIs(["mixed", "string"])) {
            return;
        }

        if (!$this->valueTypeIs(["string", "int", "float"])) {
            return;
        }

        $this->setValue("{$this->prepend}$value");
    }
}
