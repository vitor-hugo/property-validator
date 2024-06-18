<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Interfaces;

use ReflectionProperty;

interface TransformerInterface
{
    public function transform(ReflectionProperty $property, object $class): void;
}
