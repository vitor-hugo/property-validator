<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Handlers\Convertions;

use Attribute;

/**
 * Converts a string to an array of strings each of which is a substring of
 * it on boundaries formed by the string separator.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Implode extends Join
{
}
