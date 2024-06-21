<?php declare(strict_types=1);

namespace Tests\Integration\Validators\TypeCheckers\Contracts\Enums;

enum ValidStringEnum: string
{
    case Linux = "L";
    case MacOS = "M";
    case Windows = "W";
}
