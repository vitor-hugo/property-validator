<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Handlers\Strings;

use Attribute;
use Torugo\PropertyValidator\Abstract\Handler;

/**
 * Replace all occurrences of the search string with the replacement string.
 */
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class Replace extends Handler
{
    /**
     * Replace all occurrences of the search string with the replacement string.
     *
     * @param array|string $search The value being searched for. An array may be used to designate multiple values.
     * @param array|string $replace The replacement value that replaces found search values. An array may be used to designate multiple replacements.
     */
    public function __construct(
        private array|string $search,
        private array|string $replace
    ) {
    }


    public function handler(mixed $value): void
    {
        if (!$this->propertTypeIs(["mixed", "string"])) {
            return;
        }

        if (!$this->valueTypeIs(["string", "array"])) {
            return;
        }

        $newValue = str_replace($this->search, $this->replace, $value);
        $this->setValue($newValue);
    }
}
