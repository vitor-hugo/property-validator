<?php declare(strict_types=1);

namespace Tests\Integration\Validators\TypeCheckers\Contracts\Enums;

enum InvalidEnum
{
    case Android;
    case iOS;
    case iPadOS;
    case WatchOS;
}
