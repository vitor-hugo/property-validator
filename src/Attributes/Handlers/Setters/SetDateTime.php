<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Handlers\Setters;

use Attribute;
use DateTime;
use DateTimeZone;
use Torugo\PropertyValidator\Abstract\Handler;

/**
 * Sets the property value as DateTime object or formatted string,
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class SetDateTime extends Handler
{
    /**
     * @param string $datetime DateTime object constructor option (default 'now').
     * @param string|null $format If provided, the value will be setted as a formatted string.
     * @param \DateTimeZone|null $timezone A DateTimeZone object representing
     *                                     the timezone of $datetime. If $timezone
     *                                     is omitted or null, the current
     *                                     timezone will be used.
     */
    public function __construct(
        private string $datetime = "now",
        private string|null $format = null,
        private DateTimeZone|null $timezone = null
    ) {
    }


    public function handler(mixed $_): void
    {
        $datetime = new DateTime($this->datetime, $this->timezone);

        if (!empty($this->format)) {
            $this->expectPropertyTypeToBe(["string", "mixed"]);
            $this->setValue($datetime->format($this->format));
            return;
        }

        $this->setValue($datetime);
    }
}
