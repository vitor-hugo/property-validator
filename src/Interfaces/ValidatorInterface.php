<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Interfaces;

use ReflectionProperty;

interface ValidatorInterface
{
    public function validate(ReflectionProperty $property, object $class): void;
}
