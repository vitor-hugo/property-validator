<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Handlers\Strings;

use Attribute;
use Torugo\PropertyValidator\Abstract\Handler;

/**
 * Strip whitespace (or other characters) from the beginning and end of a string.
 */
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class Trim extends Handler
{
    /**
     * @param string $characters The stripped `characters` can be specified using
     * the characters parameter. Simply list all characters that you want to be stripped.
     * With `..` you can specify a range of characters.
     */
    public function __construct(private string $characters = " \n\r\t\v\x00")
    {
    }


    public function handler(mixed $value): void
    {
        if (!$this->propertTypeIs(["mixed", "string"])) {
            return;
        }

        if (!$this->valueTypeIs(["string"])) {
            return;
        }

        $this->setValue(trim($value, $this->characters));
    }
}
