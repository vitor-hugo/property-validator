<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Setters;

use Attribute;
use Torugo\PropertyValidator\Abstract\Setter;

/**
 * This attribute wraps the PHP `call_user_func_array` function.
 * [Visit the documentation](https://www.php.net/manual/en/function.call-user-func-array.php) to lear more.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class SetFromCallback extends Setter
{
    /**
     * @param string|array $callback The callable to be called.
     * @param array $args The parameters to be passed to the callback, as an array.
     */
    public function __construct(
        private string|array $callback,
        private array $args = []
    ) {
    }


    public function setter(): void
    {
        $val = call_user_func_array($this->callback, $this->args);
        $this->setValue($val);
    }
}
