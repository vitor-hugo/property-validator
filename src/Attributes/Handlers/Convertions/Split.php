<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Handlers\Convertions;

use Attribute;
use Torugo\PropertyValidator\Abstract\Handler;

/**
 * Converts a string to an array of strings each of which is a substring of
 * it on boundaries formed by the string separator.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Split extends Handler
{
    /**
     * Converts a string to an array of strings each of which is
     * a substring of it on boundaries formed by the string separator.
     *
     * @param string $separator The boundary string.
     * @param int $limit If limit is set and positive, the returned array will
     *                   contain a maximum of limit elements with the last
     *                   element containing the rest of string.
     *                   If the limit parameter is negative, all components
     *                   except the last - limit are returned.
     *                   If the limit parameter is zero, then this is treated as 1.
     */
    public function __construct(
        private string $separator = "",
        private int $limit = PHP_INT_MAX
    ) {
    }

    public function handler(mixed $value): void
    {
        $this->expectPropertyTypeToBe(["mixed"]);

        if (!$this->valueTypeIs(["string"])) {
            return;
        }

        $arr = explode($this->separator, $value, $this->limit);
        $this->setValue($arr);
    }
}
