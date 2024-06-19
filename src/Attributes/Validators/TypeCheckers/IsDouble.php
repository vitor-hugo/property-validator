<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\TypeCheckers;

use Attribute;

/**
 * IsDouble is just an alias for IsFloat attribute
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsDouble extends IsFloat
{
}
