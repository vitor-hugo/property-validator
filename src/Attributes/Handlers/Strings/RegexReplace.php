<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Handlers\Strings;

use Attribute;
use Torugo\PropertyValidator\Abstract\Handler;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class RegexReplace extends Handler
{
    /**
     * Replace regular expression with multibyte support.
     *
     * Scans the property string value for matches to `$pattern`,
     * then replaces the matched text with `$replacement`.
     *
     * Under the hood uses [`mb_ereg_replace()`](https://www.php.net/manual/en/function.mb-ereg-replace)
     *
     * Unlike `preg_replace`, on `mb_ereg_replace` you don't need to surround the `pattern` with slashes (/).
     *
     * @param string $pattern The regular expression pattern. Multibyte characters can be used.
     * @param string $replacement The replacement text.
     */
    public function __construct(
        private string $pattern,
        private string $replacement,
    ) {
    }

    public function handler(mixed $value): void
    {
        if (!$this->propertTypeIs(["mixed", "string"])) {
            return;
        }

        if (!$this->valueTypeIs(["string"])) {
            return;
        }

        // Unlike preg_replace, mb_ereg_replace doesn't use separators
        $this->pattern = trim($this->pattern, " /");
        $newValue = mb_ereg_replace($this->pattern, $this->replacement, $value);

        if ($newValue == false || $newValue == null) {
            return;
        }

        $this->setValue($newValue);
    }
}
