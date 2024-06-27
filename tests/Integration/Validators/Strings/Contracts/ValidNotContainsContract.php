<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Strings\NotContains;

class ValidNotContainsContract extends BaseValidationTestClass
{
    #[NotContains('Break')] // case sensitive enabled
    public string $str1 = 'See eye to eye';

    #[NotContains('CUT', false)] // case sensitive disabled
    public string $str2 = 'When pigs fly';

    #[NotContains('BULLET', false, 'No bullets please!')] // Custom error message
    public string $str3 = 'Let the cat out of the bag';
}
