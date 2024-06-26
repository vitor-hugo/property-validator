<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Strings\Contains;

class ValidContainsContract extends BaseValidationTestClass
{
    #[Contains('eye')] // case sensitive enabled
    public string $str1 = 'See eye to eye';

    #[Contains('pigs', false)] // case sensitive disabled
    public string $str2 = 'When pigs fly';

    #[Contains('cat', false, 'Where is the cat!?')] // Custom error message
    public string $str3 = 'Let the cat out of the bag';
}
