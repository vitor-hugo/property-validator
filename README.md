> [!NOTE]
> THIS PACKAGE IS UNDER DEVELOPMENT.

# Property Validator <!-- omit in toc -->

*Validators* and *Handlers* for class properties.  
Commonly used to create DTOs (Data Transfer Objects).

Inspired by [*class-validator*](https://github.com/typestack/class-validator) for Typescript.


# Table of Contents <!-- omit in toc -->

- [Requirements](#requirements)
- [Instalation](#instalation)
- [Usage](#usage)
  - [Validating the data](#validating-the-data)
  - [Error Handling](#error-handling)
  - [Custom error message](#custom-error-message)
- [Validators](#validators)
  - [Common](#common)
    - [IsOptional](#isoptional)
    - [IsRequired](#isrequired)
  - [Type Checkers](#type-checkers)
    - [IsBoolean](#isboolean)
    - [IsDateTime](#isdatetime)
    - [IsDouble](#isdouble)
    - [IsEnum](#isenum)
    - [IsFloat](#isfloat)
    - [IsInt](#isint)
    - [IsInteger](#isinteger)
    - [IsNumberic](#isnumberic)
    - [IsString](#isstring)
  - [Arrays](#arrays)
    - [ArrayContains](#arraycontains)
    - [ArrayNotContains](#arraynotcontains)
  - [Numbers](#numbers)
    - [IsDivisibleBy](#isdivisibleby)
    - [IsNegative](#isnegative)
    - [IsPositive](#ispositive)
    - [Max](#max)
    - [Min](#min)
  - [Strings](#strings)
    - [Contains](#contains)
    - [IsAlpha](#isalpha)
    - [IsAlphanumeric](#isalphanumeric)
    - [IsBase64](#isbase64)
    - [IsCnpj](#iscnpj)
    - [IsCpf](#iscpf)
    - [IsEmail](#isemail)
    - [IsNumeric](#isnumeric)
    - [IsUrl](#isurl)
    - [Length](#length)
    - [MaxLength](#maxlength)
    - [MinLength](#minlength)
    - [NotContains](#notcontains)
    - [MatchRegex](#matchregex)
- [Contribute](#contribute)
- [License](#license)


# Requirements

- PHP 8.2+
- PHP [mbstring extension](https://www.php.net/manual/en/mbstring.installation.php) installed and loaded.
- Composer 2+


# Instalation

On your terminal type:
```shell
composer require torugo/property-validator
```

Or add to your require list on `composer.json` file:
```json
{
    "require": {
        "torugo/property-validator": "^1"
    }
}
```

# Usage

This library is based on the [PHP Attributes](https://www.php.net/manual/en/language.attributes.php) resource. 

## Example <!-- omit in toc -->

```php
class SignInDto
{
    #[IsRequired()]
    #[MaxLenth(100)]
    #[IsEmail()]
    #[ToLowerCase()]
    public $email = "";

    #[IsRequired()]
    #[IsString()]
    #[Length(8, 100)]
    public $password = "";

    #[IsOptional()]
    #[IsBoolean()]
    public $keepConnected = false;

    public function validate()
    {
        PropertyAttributes::validate($this);
    }
}
```

## Validating the data

There are two ways to validate property values:
1. by adding a method inside your class that calls `PropertyValidator::validate` like example above;
2. Or by calling it from anywhere passing an instance of the class.


### Example <!-- omit in toc -->

Using the class `SignInDto` from [usage example](#usage) above.

```php
use Torugo\PropertyValidator\PropertyValidator;

$signInDto = new SignInDto;
$signInDto->email = "email@host.com";
$signInDto->password = "MySuperStrongPassword!";
$signInDto->keepConnected = true;

// Using method inside the class
$signInDto->validate();

// or passing the instantiated class
PropertyValidator::validate($signInDto);
```


## Error Handling

Validators can throw:

**`ValidationException`:**  
Throwed on validation errors.

**`InvalidTypeException`:**  
Throwed when the property is declared with invalid type,
or the received data has invalid type.

So you can wrap the validation in a `try/catch` block.

### Examples <!-- omit in toc -->

```php
try {
    $signInDto->validate();
} catch (\Throwable $th) {
    // Handle the error
}
```

or

```php
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;

try {
    PropertyValidator::validate($signInDto);
} catch (ValidationException $ex) {
    // Handle the error
} catch (InvalidTypeException $ex) {
    // Handle the error
} catch (\Throwable $th) {
    // Handle the error
}
```


## Custom error message

All [**VALIDATING ATTRIBUTES**](#validating-attributes) have an argument
called `$errorMessage`, where you can define a custom error message.
If not defined, the default error messages from each validator will be thrown.

Consult each validator's documentation to see the position of the argument,
or use PHP's named arguments feature.

### Example <!-- omit in toc -->

```php
class SignInDto
{
    #[IsRequired("Email is required")]
    #[MaxLenth(100, "Email can have up to 100 characters")]
    #[IsEmail(errorMessage: "Invalid email")] // named argument
    #[ToLowerCase()]
    public $email = "";
    
    //...
}
```

<!-- MARK: Validators -->

# Validators

## Common

### IsOptional

Defines a property as optional, so its value can be empty or null.

> [!NOTE]
> By default, all properties of a class that use any of the attributes
> of this library are treated as required.

```php
use Torugo\PropertyValidator\Attributes\Common\IsOptional;
```

#### Examples <!-- omit in toc -->

> [!IMPORTANT]
> When setting the type of a property other than "mixed", you must set the
> type to optional as well by placing a question mark a the beggining.  
> E.g. `?string`, `?int`, `?array`, ...

```php
#[IsOptional()]
public mixed $prop = null; // valid

#[IsOptional()]
public ?string $prop = ""; // valid, string can be emtpy

#[IsOptional()]
public ?array $prop = []; // valid, array can be empty

#[IsOptional()]
public string $prop = null; // invalid, should be setted as ?string
```

---

### IsRequired

Defines a property as required, so that the value cannot be null or empty.

By default, all properties of a class that use any of the attributes in this
library are treated as required, so using this attribute is only for defining
a custom error message when necessary.

```php
use Torugo\PropertyValidator\Attributes\Common\IsRequired;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description           |
| :------------- | :----- | :-------------------- |
| `errorMessage` | string | Custom error message. |

#### Examples <!-- omit in toc -->

```php
#[IsRequired("Password cannot be empty")]
public string $password = ""; // invalid

#[IsRequired("My prop cannot be empty")]
public array $prop = []; // invalid

#[IsRequired("Prop can't be empty or null")]
public mixed $prop = null; // invalid
```


## Type Checkers

### IsBoolean

Validates wheter a property data is a valid boolean value.

```php
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsBoolean;
```

#### Parameters <!-- omit in toc -->

| Parameter          | Type   | Description                                             |
| :----------------- | :----- | :------------------------------------------------------ |
| `convertToBoolean` | bool   | Converts accepted values to boolean. (Default: `false`) |
| `errorMessage`     | string | Custom error message.                                   |


#### Examples <!-- omit in toc -->

```php
#[IsBoolean()]
public mixed $prop = true;

#[IsBoolean()]
public mixed $prop = "no"; // Is evaluated as false, but not converted

#[IsBoolean(true)]
public mixed $prop = "yes"; // Will convert to true
```

Accepted values:

| Value     | Type   | Evaluate as |
| :-------- | :----- | :---------- |
| `1`       | int    | TRUE        |
| `"1"`     | string | TRUE        |
| `"true"`  | string | TRUE        |
| `"t"`     | string | TRUE        |
| `"ok"`    | string | TRUE        |
| `"yes"`   | string | TRUE        |
| `"y"`     | string | TRUE        |
| `"sim"`   | string | TRUE        |
| `"s"`     | string | TRUE        |
| `0`       | int    | FALSE       |
| `"0"`     | string | FALSE       |
| `"false"` | string | FALSE       |
| `"f"`     | string | FALSE       |
| `"no"`    | string | FALSE       |
| `"not"`   | string | FALSE       |
| `"n"`     | string | FALSE       |
| `"não"`   | string | FALSE       |
| `"nao"`   | string | FALSE       |

---

### IsDateTime

Validates whether the property value is a valid date time string.

```php
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsDateTime;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description                                                                                                   |
| :------------- | :----- | :------------------------------------------------------------------------------------------------------------ |
| `format`       | string | Valid PHP [`DateTime::format`](https://www.php.net/manual/en/datetime.format.php) (Default: `"Y-m-d H:i:s"`). |
| `toDateTime`   | bool   | Converts date time string to PHP DateTime object (Default: `false`)                                           |
| `errorMessage` | string | Custom error message.                                                                                         |


#### Examples <!-- omit in toc -->

```php
#[IsDateTime()]
public string $dt = "2024-06-26 13:56:24"; // valid

#[IsDateTime("M d Y", true)]
public mixed $prop = "Jun 26 2024"; // valid, will be converted to \DateTime object

#[IsDateTime("m-d-Y")]
public mixed $prop = "2017-08-01"; // Throws ValidationException due to icompatible date/time format

#[IsDateTime("m-d-Y", true)]
public string $prop = "2017-08-01'; // Throws InvalidTypeException, property type should be 'mixed"
```

---

### IsDouble

IsDouble is just an alias to [`IsFloat`](#isfloat) validator.

---

### IsEnum

Validates if the property's value is a member of a given [backed enum](https://www.php.net/manual/en/language.enumerations.backed.php).

```php
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsEnum;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description           |
| :------------- | :----- | :-------------------- |
| `enum`         | string | The enum name.        |
| `errorMessage` | string | Custom error message. |


#### Examples <!-- omit in toc -->

> [!IMPORTANT]
> The ENUM used to validate the data must be [BACKED](https://www.php.net/manual/en/language.enumerations.backed.php).

<table>
<tr>
<th>Valid<br>String enum</th>
<th>Valid<br>Int enum</th>
<th>Invalid<br>Not backed enum</th>
</tr>
<tr>
<td>
<pre lang="php">enum DeskOS: string
{
  case Linux = "L";
  case MacOS = "M";
  case Windows = "W";
}</pre>
</td>
<td>
<pre lang="php">enum Database: int 
{
  case MySql = 0;
  case Postgres = 1;
  case Mongo = 2;
}</pre>
</td>
<td>
<pre lang="php">enum MobileOS
{
  case Android;
  case iOS;
  case iPadOS;
}</pre>
</td>
</tr>
</table>


```php
#[IsEnum(DeskOS::class)]
public string $desktopOS = "L"; // valid

#[IsFloat(Database:class)]
public int $database = 1; // valid

#[IsFloat(Database:class)]
public int $database = 3; // Invalid, not exists

#[IsFloat(MobileOS:class)]
public mixed $num = "Android"; // Invalid, not backed enum
```

---

### IsFloat

Validates if a value's type is FLOAT.

```php
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsFloat;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description           |
| :------------- | :----- | :-------------------- |
| `errorMessage` | string | Custom error message. |

#### Examples <!-- omit in toc -->
 
```php
#[IsFloat()]
public float $num = 3.1415; // valid

#[IsFloat()]
public float $num = 124; // valid

#[IsFloat()]
public mixed $num = "9.99"; // Invalid
```

---

### IsInt

Validates whether the value of a property is of type integer.

```php
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsFloat;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description           |
| :------------- | :----- | :-------------------- |
| `errorMessage` | string | Custom error message. |

#### Examples <!-- omit in toc -->

```php
#[IsInt()]
public int $num = 2048; // valid

#[IsInt()]
public mixed $num = 9.99; // invalid

#[IsInt()]
public mixed $num = "512"; // Invalid
```

---

### IsInteger

`IsInterger` is just an alias to [`IsInt`](#isint) validator.

---

### IsNumberic

Validates whether the value of a property is numeric.
Only float, int or numeric string types are allowed.

```php
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsNumeric;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description           |
| :------------- | :----- | :-------------------- |
| `errorMessage` | string | Custom error message. |

#### Examples <!-- omit in toc -->

> [!IMPORTANT]
> This validator requires the property to be set to `mixed`

```php
#[IsNumeric()]
public $num = 2048; // valid

#[IsNumeric()]
public mixed $num = 9.99; // valid

#[IsNumeric()]
public mixed $num = "512.256.128,64"; // valid

#[IsNumeric()]
public mixed $num = "USD 9.99" ; // Invalid

#[IsNumeric()]
public int $num = 1983; // Invalid, property must be declared as mixed
```

---

### IsString

Validates whether the type of a value is string.

```php
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsString;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description           |
| :------------- | :----- | :-------------------- |
| `errorMessage` | string | Custom error message. |

#### Examples <!-- omit in toc -->

```php
#[IsString()]
public string $prop = "I'll be back"; // valid

#[IsString()]
public mixed $prop = "R$ 3.547,61"; // valid

#[IsString()]
public $prop = ["A", "B", "C"]; // invalid

#[IsString()]
public $prop = 898; // invalid
```


## Arrays

### ArrayContains
### ArrayNotContains


## Numbers

### IsDivisibleBy
### IsNegative
### IsPositive
### Max
### Min


## Strings

> [!IMPORTANT]
> All string validators in this section extend the `IsString` validator,
> so you don't need to use it.

### Contains

Validates whether a substring is contained in the property's value.

```php
use Torugo\PropertyValidator\Attributes\Validators\Strings\Contains;
```

#### Parameters <!-- omit in toc -->

| Parameter       | Type   | Description                                          |
| :-------------- | :----- | :--------------------------------------------------- |
| `substring`     | string | The substring to search for in the property's value. |
| `caseSensitive` | bool   | Case sensitiveness. (Default: `true`)                |
| `errorMessage`  | string | Custom error message.                                |

#### Examples <!-- omit in toc -->

```php
#[Contains("Approved")]
public string $prop = "Approved"; // valid

#[Contains("Approved")]
public mixed $prop = "Refused"; // invalid

#[Contains("Approved", false)] // case sensitiveness disabled
public $prop = "APPROVED"; // valid

#[Contains("Approved")] // case sensitiveness enalbed
public $prop = "APPROVED"; // invalid
```

---

### IsAlpha
### IsAlphanumeric
### IsBase64
### IsCnpj
### IsCpf
### IsEmail
### IsNumeric
### IsUrl

---

### Length

Validates if the length of a string is between a minimum and maximum parameters.

```php
use Torugo\PropertyValidator\Attributes\Validators\Strings\Length;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description                                |
| :------------- | :----- | :----------------------------------------- |
| `min`          | int    | Minimum acceptable length. (must be >= 0). |
| `max`          | int    | Maximum acceptable length. (must be >= 1)  |
| `errorMessage` | string | Custom error message.                      |

#### Examples <!-- omit in toc -->

```php
#[Length(1, 60)]
public $text = "They may take our lives, but they'll never take our freedom!"; // valid

#[Length(8, 64)]
public $password = "9a2f534"; // invalid
```

---

### MaxLength
### MinLength

---

### NotContains

Checks whether a substring is contained in the received value,
if so, throws an exception.


```php
use Torugo\PropertyValidator\Attributes\Validators\Strings\NotContains;
```

#### Parameters <!-- omit in toc -->

| Parameter       | Type   | Description                                          |
| :-------------- | :----- | :--------------------------------------------------- |
| `substring`     | string | The substring to search for in the property's value. |
| `caseSensitive` | bool   | Case sensitiveness. (Default: `true`)                |
| `errorMessage`  | string | Custom error message.                                |

#### Examples <!-- omit in toc -->

```php
#[NotContains("Break")]
public string $prop = "Break a leg"; // throws ValidationException

#[NotContains("CUT")]
public mixed $prop = "To cut corners"; // not throws, case sensitiveness enabled

#[NotContains("BULLET", false)] // Case sensitiveness enabled
public $prop = "Bite the bullet"; // throws ValidationException
```

---

### MatchRegex


# Contribute

It is currently not open to contributions, I intend to make it available as soon as possible.


# License

This library is licensed under the MIT License - see the LICENSE file for details.
