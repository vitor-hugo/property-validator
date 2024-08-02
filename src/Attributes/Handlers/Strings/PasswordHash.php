<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Handlers\Strings;

use Attribute;
use Torugo\PropertyValidator\Abstract\Handler;

/**
 * Generates a new password hash using a strong one-way hashing algorithm.
 * Uses PHP [`password_hash()`](https://www.php.net/manual/en/function.password-hash.php) function.
 */
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class PasswordHash extends Handler
{
    /**
     * @param int|string|null $algo A password algorithm constant denoting the
     *                              algorithm to use when hashing the password.
     * @param array $options An associative array containing options. See the
     *                       password algorithm constants for documentation
     *                       on the supported options for each algorithm.
     *                       If omitted, a random salt will be created and the
     *                       default cost will be used.
     */
    public function __construct(
        private int|string|null $algo = PASSWORD_DEFAULT,
        private array $options = []
    ) {
    }


    public function handler(mixed $value): void
    {
        if (!$this->propertTypeIs(["mixed", "string"])) {
            return;
        }

        if (!$this->valueTypeIs(["string"])) {
            return;
        }

        $hash = password_hash($value, $this->algo, $this->options);

        $this->setValue($hash);
    }
}
