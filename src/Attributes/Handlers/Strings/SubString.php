<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Handlers\Strings;

use Attribute;
use Torugo\PropertyValidator\Abstract\Handler;

/**
 * Returns the portion of string specified by the offset and length parameters.
 */
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class SubString extends Handler
{
    /**
     * @param int $offset If `offset` is non-negative, the returned string will
     * start at the `offset`'th position in `string`, counting from zero. For
     * instance, in the string ' `abcdef`', the character at position `0` is
     * ' `a`', the character at position `2` is ' `c`', and so forth. If `offset`
     * is negative, the returned string will start at the `offset`'th character
     * from the end of `string`. If `string` is less than `offset` characters
     * long, an empty string will be returned. Example #1 Using a negative `offset`
     *   ```php
     *   substr("abcdef", -1);  // returns "f"
     *   substr("abcdef", -2);  // returns "ef"
     *   substr("abcdef", -3, 1); // returns "d"
     *   ```
     * @param int|null $length If `length` is given and is positive, the string
     * returned will contain at most `length` characters beginning from `offset`
     * (depending on the length of `string`). If `length` is given and is
     * negative, then that many characters will be omitted from the end of
     * `string` (after the start position has been calculated when a `offset`
     * is negative). If `offset` denotes the position of this truncation or
     * beyond, an empty string will be returned. If `length` is given and is `0`,
     * an empty string will be returned. If `length` is omitted or `null`,
     * the substring starting from `offset` until the end of the string will
     * be returned. Example #2 Using a negative `length`
     *   ```php
     *   substr("abcdef", 0, -1); // returns "abcde"
     *   substr("abcdef", 2, -1); // returns "cde"
     *   substr("abcdef", 4, -4); // returns ""; prior to PHP 8.0.0, false was returned
     *   substr("abcdef", -3, -1); // returns "de"
     *   ```
     */
    public function __construct(private int $offset, private ?int $length = null)
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

        $sub = substr($value, $this->offset, $this->length);

        if ($sub == false) {
            $sub = "";
        }

        $this->setValue($sub);
    }
}
