<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Handlers\Strings;

use Attribute;
use Torugo\PropertyValidator\Abstract\Handler;

/**
 * Adds a string to the end of another.
 */
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class Prepend extends Handler
{
    /**
     * @param string $append String to be placed at the end
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
