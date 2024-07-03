<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Handlers\Strings;

use Attribute;
use Torugo\PropertyValidator\Abstract\Handler;
use Torugo\TString\Traits\Handlers\TStringToUpperCase;

/**
 * Converts a string or string elements in an array to upper case.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class ToUpperCase extends Handler
{
    use TStringToUpperCase;

    public function handler(mixed $value): void
    {
        $valueType = $this->getType($value);

        if ($valueType === "string") {
            $this->setValue(self::toUpperCase($value));
            return;
        }

        if ($valueType === "array") {
            array_walk_recursive($value, function (&$v) {
                if (gettype($v) === 'string') {
                    $v = self::toUpperCase($v);
                }
            });

            $this->setValue($value);
        }
    }
}
