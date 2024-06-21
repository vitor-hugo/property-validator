<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\TypeCheckers;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;

/**
 * Validates if the property's value is a member of a given enum
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsEnum extends Validator
{
    /**
     * @param string $enum Enum's namespace
     * @param string|null $errorMessage Message to be displayed in case of validation error.
     */
    public function __construct(private string $enum, string|null $errorMessage = null)
    {
        parent::__construct($errorMessage);
    }


    public function validation(mixed $value): void
    {
        $this->expectPropertyTypeToBe(["string", "int", "mixed"]);
        $this->validateIfEnumExists();
        $this->validateIfEnumIsBacked();
        $this->validateReceivedValueType($value);
        $this->validateIfValueIsAMemberOfEnum($value);
    }


    private function validateIfEnumExists(): void
    {
        if (!enum_exists($this->enum)) {
            $enum = str_replace("::class", "", $this->enum);
            $this->throwValidationException("Enum '$enum' does not exists.");
        }
    }


    private function validateIfEnumIsBacked(): void
    {
        $reflectionEnum = new \ReflectionEnum($this->enum);
        $enumType = (string) $reflectionEnum->getBackingType();

        if ($enumType !== "string" && $enumType !== "int") {
            $enumName = $this->getClassName($this->enum);
            throw new InvalidTypeException("Enum '$enumName' must be backed as 'string' or 'int'.");
        }
    }


    private function validateReceivedValueType(mixed $value): void
    {
        $type = $this->getType($value);
        $expected = ["string", "int"];

        if (!in_array($type, $expected, true)) {
            $this->throwValidationException("Property '{$this->propertyName}' expects to receive a string or an int value, received $type.");
        }
    }


    private function validateIfValueIsAMemberOfEnum(mixed $value): void
    {
        try {
            $check = $this->enum::tryFrom($value);
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            $this->throwValidationException("$message.", 3);
        }

        if ($check == false) {
            $enumName = $this->getClassName($this->enum);
            $this->throwValidationException("The value '$value' on property '{$this->propertyName}' is not member of '$enumName'.", 4);
        }
    }
}
