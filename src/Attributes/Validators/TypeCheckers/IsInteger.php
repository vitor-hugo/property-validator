<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\TypeCheckers;

use Attribute;

/**
 * IsInteger is just an alias for IsInt attribute
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsInteger extends IsInt
{
}
