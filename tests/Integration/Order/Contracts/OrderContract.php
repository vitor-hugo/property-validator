<?php declare(strict_types=1);

namespace Tests\Integration\Order\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Handlers\Strings\Append;
use Torugo\PropertyValidator\Attributes\Handlers\Strings\Prepend;
use Torugo\PropertyValidator\Attributes\Handlers\Strings\ToLowerCase;
use Torugo\PropertyValidator\Attributes\Validators\Strings\IsEmail;

class OrderContract extends BaseValidationTestClass
{
    #[IsEmail()]
    #[Prepend("MAILTO:")]
    #[ToLowerCase()]
    #[append(";")]
    public mixed $email = "";
}
