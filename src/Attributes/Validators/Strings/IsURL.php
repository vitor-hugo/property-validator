<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Strings;

use Attribute;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsString;
use Torugo\TString\Options\UrlOptions;
use Torugo\TString\Traits\Validators\TStringIsUrl;

/**
 * Validates whether a string has a valid URL structure.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsURL extends IsString
{
    use TStringIsUrl;

    /**
     * @param UrlOptions|null $options Url validation options, if null uses the default config.
     * @param string|null $errorMessage Custom error message.
     */
    public function __construct(private ?UrlOptions $options = null, string|null $errorMessage = null)
    {
        parent::__construct($errorMessage);
    }


    public function validation(mixed $value): void
    {
        parent::validation($value);

        if (self::isUrl($value, $this->options) === false) {
            $this->throwValidationException("Invalid URL ('$value') on property '{$this->propertyName}'.");
        }
    }
}
