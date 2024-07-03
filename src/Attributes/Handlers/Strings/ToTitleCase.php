<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Handlers\Strings;

use Attribute;
use Torugo\PropertyValidator\Abstract\Handler;
use Torugo\TString\Traits\Handlers\TStringToTitleCase;

/**
 * Converts a string or string elements in an array to title case.
 * Check TString [docs](https://github.com/vitor-hugo/string-lib-php?tab=readme-ov-file#totitlecase).
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class ToTitleCase extends Handler
{
    use TStringToTitleCase;

    /**
     * @param bool $fixRomanNumerals Keep roman numerals uppercased (up to 6 digits)
     * @param bool $fixPortuguesePrepositions Keep portuguese prepositions in lowercase
     */
    public function __construct(
        private bool $fixRomanNumerals = false,
        private bool $fixPortuguesePrepositions = false
    ) {
    }

    public function handler(mixed $value): void
    {
        $valueType = $this->getType($value);

        if ($valueType == 'string') {
            $this->setValue(
                self::toTitleCase(
                    $value,
                    $this->fixRomanNumerals,
                    $this->fixPortuguesePrepositions
                )
            );
            return;
        }

        if ($valueType == 'array') {
            array_walk_recursive($value, function (&$v) {
                if (gettype($v) === 'string') {
                    $v = self::toTitleCase(
                        $v,
                        $this->fixRomanNumerals,
                        $this->fixPortuguesePrepositions
                    );
                }
            });

            $this->setValue($value);
        }

    }
}
