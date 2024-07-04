<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Handlers\Convertions;

use Attribute;
use Torugo\PropertyValidator\Abstract\Handler;

/**
 * Converts an array to a string by recursively joining the
 * values ​​by placing a separator between them
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Join extends Handler
{
    /**
     * Converts an array to a string by recursively joining the
     * values ​​by placing a separator between them.
     *
     * @param string $separator String to be placed between array values.
     * @param bool $includeKeys Includes the array keys before each value.
     * @param string $keySeparator String to be placed between the key and value.
     */
    public function __construct(
        private string $separator = "",
        private bool $includeKeys = false,
        private string $keySeparator = ": "
    ) {
    }


    public function handler(mixed $array): void
    {
        $this->expectPropertyTypeToBe(["mixed"]);

        if (!$this->valueTypeIs(["array"])) {
            return;
        }

        $result = "";
        array_walk_recursive($array, function ($value, $key) use (&$result) {
            if ($this->includeKeys) {
                $result .= "$key{$this->keySeparator}";
            }
            $result .= "$value{$this->separator}";
        });

        $result = rtrim($result, $this->separator);
        $this->setValue($result);
    }


}
