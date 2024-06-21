<?php declare(strict_types=1);

namespace Tests\Integration\Validators\TypeCheckers\Contracts\Enums;

enum ValidIntEnum: int
{
    case MariaDB = 0;
    case MySql = 1;
    case Oracle = 2;
    case Postgres = 3;
    case SqlServer = 4;
}
