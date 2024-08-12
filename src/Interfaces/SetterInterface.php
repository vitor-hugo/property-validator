<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Interfaces;

use ReflectionProperty;

interface SetterInterface
{
    public function set(ReflectionProperty $property, object $class): void;
}
