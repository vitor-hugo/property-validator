<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Strings\IsURL;

class ValidIsURLContract extends BaseValidationTestClass
{
    #[IsURL()]
    public string $url1 = "www.google.com";

    #[IsURL(null, 'Invalid URL!!!')] // Custom error message
    public string $url2 = "www.php.net";
}
