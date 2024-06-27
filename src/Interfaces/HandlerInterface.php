<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Interfaces;

use ReflectionProperty;

interface HandlerInterface
{
    public function handle(ReflectionProperty $property, object $class): void;
}
