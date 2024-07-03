<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Handlers\Strings;

use Attribute;
use Torugo\PropertyValidator\Abstract\Handler;
use Torugo\TString\Traits\Handlers\TStringToLowerCase;

/**
 * Converts a string or string elements in an array to lower case.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class ToLowerCase extends Handler
{
    use TStringToLowerCase;

    public function handler(mixed $value): void
    {
        $valueType = $this->getType($value);

        if ($valueType == 'string') {
            $this->setValue(self::toLowerCase($value));
            return;
        } else if ($valueType == 'array') {
            array_walk_recursive($value, function (&$v) {
                if (gettype($v) === 'string') {
                    $v = self::toLowerCase($v);
                }
            });

            $this->setValue($value);
        }


    }
}
