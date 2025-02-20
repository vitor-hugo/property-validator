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
    - [IsEqualTo](#isequalto)
    - [IsOptional](#isoptional)
    - [IsRequired](#isrequired)
    - [SameAs](#sameas)
  - [Type Checkers](#type-checkers)
    - [IsArray](#isarray)
    - [IsBoolean](#isboolean)
    - [IsDateTime](#isdatetime)
    - [IsDouble](#isdouble)
    - [IsEnum](#isenum)
    - [IsFloat](#isfloat)
    - [IsInt](#isint)
    - [IsInteger](#isinteger)
    - [IsNumeric](#isnumeric)
    - [IsString](#isstring)
  - [Arrays](#arrays)
    - [ArrayContains](#arraycontains)
    - [ArrayMaxSize](#arraymaxsize)
    - [ArrayMinSize](#arrayminsize)
    - [ArrayKeyExists](#arraykeyexists)
    - [ArrayNotContains](#arraynotcontains)
  - [Date/Time](#datetime)
    - [MaxDateTime](#maxdatetime)
    - [MinDateTime](#mindatetime)
  - [Numbers](#numbers)
    - [IsDivisibleBy](#isdivisibleby)
    - [IsNegative](#isnegative)
    - [IsPositive](#ispositive)
    - [Max](#max)
    - [Min](#min)
    - [Range](#range)
  - [Strings](#strings)
    - [Contains](#contains)
    - [IsAlpha](#isalpha)
    - [IsAlphanumeric](#isalphanumeric)
    - [IsBase64](#isbase64)
    - [IsCnpj](#iscnpj)
    - [IsCpf](#iscpf)
    - [IsEmail](#isemail)
- [IsIP](#isip)
      - [Parameters](#parameters)
    - [IsSemVer](#issemver)
    - [IsTUID](#istuid)
    - [IsURL](#isurl)
    - [Length](#length)
    - [Matches](#matches)
    - [MaxLength](#maxlength)
    - [MinLength](#minlength)
    - [NotContains](#notcontains)
- [Handlers](#handlers)
  - [Common](#common-1)
    - [CopyFrom](#copyfrom)
  - [Convertions](#convertions)
    - [Explode](#explode)
    - [Implode](#implode)
    - [Join](#join)
    - [Split](#split)
  - [Strings](#strings-1)
    - [Append](#append)
    - [PasswordHash](#passwordhash)
    - [Prepend](#prepend)
    - [SubString](#substring)
    - [Replace](#replace)
    - [ToLowerCase](#tolowercase)
    - [ToTitleCase](#totitlecase)
    - [ToUpperCase](#touppercase)
    - [Trim, LTrim and RTrim](#trim-ltrim-and-rtrim)
- [Setters](#setters)
  - [SetDateTime](#setdatetime)
  - [SetFromCallback](#setfromcallback)
    - [Parameters](#parameters-1)
    - [Examples](#examples)
  - [SetValueWhenEmpty](#setvaluewhenempty)
    - [Parameters](#parameters-2)
    - [Examples](#examples-1)
  - [SetValueWhenNull](#setvaluewhennull)
    - [Parameters](#parameters-3)
    - [Examples](#examples-2)
- [Custom Validators](#custom-validators)
  - [Templates](#templates)
  - [Validator class](#validator-class)
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

**`InvalidTypeException`:**  
Thrown when the property type is incorrect,
or when the type of the received value is invalid.

**`ValidationException`:**  
Thrown on validation errors, the value type is correct but,
its content is invalid.

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

Set of attributes that validate the properties of a class, do not change
its value, only check whether the data respects a certain rule of each validator.

Validators can throw [`ValidationException`](#error-handling)
and [`InvalidTypeException`](#error-handling).

## Common

### IsEqualTo

Validates whether the value of a property exactly equals to a given value.

```php
use Torugo\PropertyValidator\Attributes\Common\IsEqualTo;
```

#### Examples <!-- omit in toc -->

```php
#[IsEqualTo("A")]
public string $status = "A"; // valid

#[IsEqualTo("A")]
public string $status = "B"; // invalid

#[IsEqualTo(512)]
public $var = 512; // valid

#[IsEqualTo(512)]
public $var = 1024; // invalid
```

---

### IsOptional

Defines a property as optional, so its value can be empty or null.

> [!NOTE]
> By default, all properties of a class that use any of the attributes
> of this library are treated as NON NULLABLE, but their values can be
> empty.

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
library are treated as NON NULLABLE, so using this attribute their values cannot
be empty as well.

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

---

### SameAs

Validates whether the value of a property
is strictly equal to another in the same class

```php
use Torugo\PropertyValidator\Attributes\Common\SameAs;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description                          |
| :------------- | :----- | :----------------------------------- |
| `target`       | string | Name of the property to be compared. |
| `errorMessage` | string | Custom error message.                |

#### Examples <!-- omit in toc -->

```php
// VALID
public $password = "MySuperStrongPassword!";

#[SameAs("password")]
public $repeat = "MySuperStrongPassword!";
```

```php
//INVALID - Property name is case sensitive
public $password = "MySuperStrongPassword!";

#[SameAs("Password")]
public $repeat = "MySuperStrongPassword!";
```

```php
// INVALID - Values must have the same type
public $number1 = 512;

#[SameAs("number1")]
public $number2 = "512";
```

```php
// INVALID - If target property does not exist
public $propA = "My Prop";

#[SameAs("propC")]
public $propB = "My Prop";
```

---

## Type Checkers

### IsArray

Validates whether the value of a property is an array.

```php
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsArray;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description           |
| :------------- | :----- | :-------------------- |
| `errorMessage` | string | Custom error message. |

#### Examples <!-- omit in toc -->
 
```php
#[IsArray()]
public array $arr1 = ["A", "B", "C"]; // valid

#[IsArray()]
public array $arr2 = ["name" => "Han Solo", "ship" => "Millennium Falcon"]; // valid

#[IsArray()]
public mixed $arr3 = [[10, 29], [30, 43], [60, 92]]; // valid

#[IsArray()]
public mixed $arr4 = "A, B, C"; // invalid

#[IsArray()]
public $arr5 = "[{'name': 'Han Solo', 'ship': 'Millennium Falcon'}]"; // invalid
```

---

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

### IsNumeric

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

Validates whether an array contains a given value.

```php
use Torugo\PropertyValidator\Attributes\Validators\Arrays\ArrayContains;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description                                                   |
| :------------- | :----- | :------------------------------------------------------------ |
| `search`       | mixed  | If string, the comparison is done in a case-sensitive manner. |
| `strict`       | bool   | The type of searched value should match. (Default: `true`).   |
| `errorMessage` | string | Custom error message.                                         |

#### Examples <!-- omit in toc -->

```php
#[ArrayContains("banana")]
public $arr = ["apple", "banana", "grapes", "orange"];
// Valid

#[ArrayContains("BANANA")]
public $arr = ["apple", "banana", "grapes", "orange"];
// Invalid, string search is case sensitive

#[ArrayContains(20)]
public $arr = [10, 20, 30, 40];
// Valid

#[ArrayContains("20")]
public $arr = [10, 20, 30, 40];
// Invalid, strict type enabled

#[ArrayContains(20, false)]
public $arr = ["10", "20", "30", "40"];
// Valid, strict type disabled

#[ArrayContains("Appleseed")]
public $arr = ["firstName" => "Jhon", "lasName" => "Appleseed"];
// Valid

#[ArrayContains(["30", "40"])]
public $arr = ["10", "20", ["30", "40"]];
// Valid
```

> **TODO:**  
> Implements case insensitive string search.

### ArrayMaxSize

Checks whether the number of elements in an array
is less than or equal to a specified number.

```php
use Torugo\PropertyValidator\Attributes\Validators\Arrays\ArrayMaxSize;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description                              |
| :------------- | :----- | :--------------------------------------- |
| `max`          | int    | Maximum accepted elements. Must be >= 1. |
| `errorMessage` | string | Custom error message.                    |

#### Examples <!-- omit in toc -->

```php
// Valid
#[ArrayMaxSize(4)]
public $arr = ["apple", "banana", "grapes", "orange"];

// Valid
#[ArrayMaxSize(2)]
public $arr = ["firstName" => "Bilbo", "lastName" => "Baggins"];

// Invalid, throws ValidationException when overflows
#[ArrayMaxSize(4)]
public $arr = ["apple", "banana", "grapes", "orange", "pear"];
```

---

### ArrayMinSize

Checks whether the number of elements in an array
is greater than or equal to a specified number.

```php
use Torugo\PropertyValidator\Attributes\Validators\Arrays\ArrayMinSize;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description                              |
| :------------- | :----- | :--------------------------------------- |
| `min`          | int    | Minimum accepted elements. Must be >= 1. |
| `errorMessage` | string | Custom error message.                    |

#### Examples <!-- omit in toc -->

```php
// Valid
#[ArrayMinSize(2)]
public $arr = ["apple", "banana", "grapes", "orange"];

// Valid
#[ArrayMinSize(2)]
public $arr = ["firstName" => "Bilbo", "lastName" => "Baggins"];

// Invalid, throws ValidationException when the number of elements is lesser
#[ArrayMinSize(3)]
public $arr = ["apple", "banana"];
```

---

### ArrayKeyExists

Validates whether an array has one or more keys.

```php
use Torugo\PropertyValidator\Attributes\Validators\Arrays\ArrayNotContains;
```

#### Parameters <!-- omit in toc -->

| Parameter       | Type   | Description                                                                  |
| :-------------- | :----- | :--------------------------------------------------------------------------- |
| `keys`          | array  | Keys that must be present in the array.                                      |
| `caseSensitive` | bool   | The search for keys should or should not be case sensitive. (Default `true`) |
| `errorMessage`  | string | Custom error message.                                                        |

#### Examples <!-- omit in toc -->

```php
// Valid
#[ArrayKeyExists(["fistName", "lastName"])]
public $arr = ["firstName" => "Luke", "lastName" => "Skywalker"];

// Invalid, case sensitiveness enabled by default
#[ArrayKeyExists(["fistName", "lastName"])]
public $arr = ["FIRSTNAME" => "Luke", "LASTNAME" => "Skywalker"];

// Valid, case sensitiveness disabled
#[ArrayKeyExists(["fistName", "lastName"], false)]
public $arr = ["FIRSTNAME" => "Luke", "LASTNAME" => "Skywalker"];

// Valid
#[ArrayKeyExists(["foo", 100])]
public $arr = ["foo" => "bar", "bar" => "foo", 100 => 100];

// Invalid, 100 != "100"
#[ArrayKeyExists(["100"], false, "Custom error message")]
public $arr = ["foo" => "bar", "bar" => "foo", 100 => 100];
```

---

### ArrayNotContains

Works in the opposite direction to [ArrayContains](#arraycontains).  
Throws `ValidationException` when a certain value is found in an array.

```php
use Torugo\PropertyValidator\Attributes\Validators\Arrays\ArrayNotContains;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description                                                   |
| :------------- | :----- | :------------------------------------------------------------ |
| `search`       | mixed  | If string, the comparison is done in a case-sensitive manner. |
| `strict`       | bool   | The type of searched value should match. (Default: `true`).   |
| `errorMessage` | string | Custom error message.                                         |

#### Examples <!-- omit in toc -->

```php
// Valid
#[ArrayNotContains("pineapple")]
public $arr = ["apple", "banana", "grapes", "orange"];

// Invalid
#[ArrayNotContains("orange")]
public $arr = ["apple", "banana", "grapes", "orange"];

// Invalid
#[ArrayNotContains(30)]
public $arr = [10, 20, 30, 40];

// Valid, strict type enabled
#[ArrayNotContains("30")]
public $arr = [10, 20, 30, 40];

// Invalid, strict type disabled
#[ArrayNotContains(30, false)]
public $arr = ["10", "20", "30", "40"];

// Valid
#[ArrayNotContains("Luke")]
public $arr = ["firstName" => "Han", "lasName" => "Solo"];

// Invalid
#[ArrayNotContains(["30", "40"])]
public $arr = ["10", "20", ["30", "40"]];
```

> **TODO:**  
> Implements case insensitive string search.

---

## Date/Time

### MaxDateTime

Validates whether a DateTime instance is greater than a defined limit.

```php
use Torugo\PropertyValidator\Attributes\Validators\DateTime\MaxDateTime;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type     | Description                   |
| :------------- | :------- | :---------------------------- |
| `max`          | DateTime | Maximum acceptable Date/Time. |
| `errorMessage` | string   | Custom error message.         |

#### Examples <!-- omit in toc -->

> [!IMPORTANT]
> If you intend to validate date/time in strings, you must first use
> the [IsDateTime attribute](#isdatetime), and set the 'toDateTime'
> argument to `true`, in these cases it is mandatory to set the property
> type to `mixed`. See the examples below.

```php
#[MaxDateTime(new DateTime("now + 10 days"))]
public DateTime $date = new DateTime("now");

// Here you can receive a date/time string
#[IsDateTime("Y-m-d H:i:s", true)] // set 'toDateTime' to true
#[MaxDateTime(new DateTime("now + 10 days"))]
public mixed $dtString = "2024-13-03 12:30:45";
```

---

### MinDateTime

Validates whether a DateTime instance is before than a defined minimum date/time.

```php
use Torugo\PropertyValidator\Attributes\Validators\DateTime\MinDateTime;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type     | Description                   |
| :------------- | :------- | :---------------------------- |
| `min`          | DateTime | Minimum acceptable Date/Time. |
| `errorMessage` | string   | Custom error message.         |

#### Examples <!-- omit in toc -->

> [!IMPORTANT]
> If you intend to validate date/time in strings, you must first use
> the [IsDateTime attribute](#isdatetime), and set the 'toDateTime'
> argument to `true`, in these cases it is mandatory to set the property
> type to `mixed`. See the examples below.

```php
#[MinDateTime(new DateTime("now"))]
public DateTime $date = new DateTime("now +1 day");

// Here you can receive a date/time string
#[IsDateTime("Y-m-d H:i:s", true)] // set 'toDateTime' to true
#[MinDateTime(new DateTime("2024-13-03 12:30:45"))]
public mixed $dtString = "2024-13-03 12:30:46";
```

---

## Numbers

### IsDivisibleBy

Validates whether a number (int or float) is divisible by a given one.

```php
use Torugo\PropertyValidator\Attributes\Validators\Numbers\IsDibisibleBy;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type         | Description           |
| :------------- | :----------- | :-------------------- |
| `divisor`      | int or float | The divisor number.   |
| `errorMessage` | string       | Custom error message. |

#### Examples <!-- omit in toc -->

```php
#[IsDivisibleBy(2)]
public $num1 = 10; // valid

#[IsDivisibleBy(2.5)]
public $num1 = 7.5; // valid

#[IsDivisibleBy(3)]
public $num1 = 11; // invalid
```

---

### IsNegative

Validates if property's value is negative (lesser than zero).

```php
use Torugo\PropertyValidator\Attributes\Validators\Numbers\IsNegative;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description           |
| :------------- | :----- | :-------------------- |
| `errorMessage` | string | Custom error message. |

#### Examples <!-- omit in toc -->

```php
#[IsNegative()]
public $num1 = -13; // valid

#[IsNegative()]
public $num1 = -9.99; // valid

#[IsNegative()]
public $num1 = 0; // invalid

#[IsNegative()]
public $num1 = 12; // invalid
```

---

### IsPositive

Validates if a number is positive (greater than zero).

```php
use Torugo\PropertyValidator\Attributes\Validators\Numbers\IsPositive;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description           |
| :------------- | :----- | :-------------------- |
| `errorMessage` | string | Custom error message. |

#### Examples <!-- omit in toc -->

```php
#[IsPositive()]
public $num1 = 512; // valid

#[IsPositive()]
public $num1 = 3.1415; // valid

#[IsPositive()]
public $num1 = 0; // invalid

#[IsPositive()]
public $num1 = -19.99; // invalid
```

---

### Max

Validates whether a number (int or float) is less than or equal to a given number.

```php
use Torugo\PropertyValidator\Attributes\Validators\Numbers\Max;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type         | Description                |
| :------------- | :----------- | :------------------------- |
| `max`          | int or float | Maximum acceptable number. |
| `errorMessage` | string       | Custom error message.      |

#### Examples <!-- omit in toc -->

```php
#[Max(1024)]
public $num1 = 512; // valid

#[Max(999.99)]
public $num1 = 999.99; // valid

#[Max(-10)]
public $num1 = -11; // valid

#[Max(10)]
public $num1 = 11; // invalid

#[Max(0)]
public $num1 = 1; // invalid
```

---

### Min

Validates whether a number (int or float) is greater than or equal to a given number.

```php
use Torugo\PropertyValidator\Attributes\Validators\Numbers\Min;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type         | Description                |
| :------------- | :----------- | :------------------------- |
| `min`          | int or float | Minimum acceptable number. |
| `errorMessage` | string       | Custom error message.      |

#### Examples <!-- omit in toc -->

```php
#[Min(256)]
public $num1 = 256; // valid

#[Min(9.99)]
public $num1 = 12.99; // valid

#[Min(-5)]
public $num1 = -4; // valid

#[Min(10)]
public $num1 = 9; // invalid

#[Min(1)]
public $num1 = 0; // invalid
```

---

### Range

Validates whether a number falls within a given inclusive range.

```php
use Torugo\PropertyValidator\Attributes\Validators\Numbers\Range;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type         | Description                |
| :------------- | :----------- | :------------------------- |
| `min`          | int or float | Minimum acceptable number. |
| `max`          | int or float | Maximum acceptable number. |
| `errorMessage` | string       | Custom error message.      |

#### Examples <!-- omit in toc -->

```php
#[Range(0, 16)]
public $number = 9; // valid

#[Range(1, 9.99)]
public $number = "8.72"; // valid

#[Range(-10, 0)]
public $number = -4; // valid

#[Range(20, 0)] // will be swapped
public $number = 19; // valid

#[Range(0, 100)]
public $number = 101; // invalid

#[Range(1, 9.99)]
public $number = 10; // invalid
```

---

## Strings

> [!IMPORTANT]
> All string validators in this section extend the [`IsString`](#isstring) validator,
> so its use is unnecessary.

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

Validates if a string have only alphabetical characters.

```php
use Torugo\PropertyValidator\Attributes\Validators\Strings\IsAlpha;
```

#### Parameters <!-- omit in toc -->

| Parameter        | Type   | Description                                                                      |
| :--------------- | :----- | :------------------------------------------------------------------------------- |
| `includeUnicode` | bool   | Includes some Unicode alphabetic chars like accented letters. (Default: `false`) |
| `errorMessage`   | string | Custom error message.                                                            |

#### Examples <!-- omit in toc -->

```php
#[IsAlpha()]
public string $prop = "UZoljlNxrCYJUpDgmDmCA"; // valid

#[IsAlpha(true)] // unicode enabled
public string $prop = "XOÄfsàugKjLcpGEJÄwbvàX"; // valid

#[IsAlpha()]
public mixed $prop = "No spaces allowed"; // invalid

#[IsAlpha()]
public mixed $prop = "Wdj6Ab0pkhkS3HqUwTza"; // numbers are invalid

#[IsAlpha(true)]
public mixed $prop = "email@hots.com.br"; // invalid, symbols or ponctuation
```

---

### IsAlphanumeric

Validates if a string have only alphanumeric characters.

```php
use Torugo\PropertyValidator\Attributes\Validators\Strings\IsAlphanumeric;
```

#### Parameters <!-- omit in toc -->

| Parameter        | Type   | Description                                                                      |
| :--------------- | :----- | :------------------------------------------------------------------------------- |
| `includeUnicode` | bool   | Includes some Unicode alphabetic chars like accented letters. (Default: `false`) |
| `errorMessage`   | string | Custom error message.                                                            |

#### Examples <!-- omit in toc -->

```php
#[IsAlphanumeric()]
public string $prop = "mSfPq4Tc9ipPgX5487NG"; // valid

#[IsAlphanumeric(true)] // unicode enabled
public string $prop = "çeY4â2e4SÇ8ÂdiÀÏKTLÊ"; // valid

#[IsAlphanumeric()]
public mixed $prop = "No spaces allowed"; // invalid

#[IsAlphanumeric(true)]
public mixed $prop = "email@hots.com.br"; // invalid, symbols or ponctuation
```

---

### IsBase64

Validates whether a string is in Base64 format.  
Works with **url safe** base64 strings.

```php
use Torugo\PropertyValidator\Attributes\Validators\Strings\IsBase64;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description           |
| :------------- | :----- | :-------------------- |
| `errorMessage` | string | Custom error message. |

#### Examples <!-- omit in toc -->

```php
#[IsBase64()]
public string $b64 = "7d+n67ptfj/J+Q+O0cQ1+w=="; // valid

#[IsBase64()]
public string $b64 = "7d-n67ptfj_J-Q-O0cQ1-w"; // valid, url safe

#[IsBase64()]
public string $b64 = "7d+n67ptfj/J+Q+O0cQ1+w"; // valid, '=' right padding

#[IsBase64()]
public mixed $b64 = "FKgLuXN\qsxYnEgtyzKyxQ=="; // invalid

#[IsBase64()]
public mixed $b64 = "=HAMYja0H18A"; // invalid
```

---

### IsCnpj

Validates if a given string has a valid CNPJ registration.

The Brazil National Registry of Legal Entities number (CNPJ) is a company identification number
that must be obtained from the Department of Federal Revenue(Secretaria da Receita Federal do Brasil)
prior to the start of any business activities.

```php
use Torugo\PropertyValidator\Attributes\Validators\Strings\IsCnpj;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description           |
| :------------- | :----- | :-------------------- |
| `errorMessage` | string | Custom error message. |

#### Examples <!-- omit in toc -->

```php
#[IsCnpj()]
public $cnpj = '60391682000132';
// Valid

#[IsCnpj()]
public $cnpj = '99.453.669/0001-04';
// Valid, this is the default format

#[IsCnpj()]
public $cnpj = '99 453 669 / 0001 (04)';
// Valid, it removes non numerical characters

#[IsCnpj()]
public $cnpj = '99.453.669/0001-05';
// Invalid verification digit

#[IsCnpj()]
public $cnpj = '9953669000105';
// Invalid length

#[IsCnpj()]
public $cnpj = '999.453.669/0001-04';
// Invalid length
```

> [!IMPORTANT]
> The cnpj numbers above were generated randomly using [this tool](https://www.4devs.com.br/gerador_de_cnpj).  
> If one of them belongs to you, please send me a request to remove.

---

### IsCpf

Validates if a given string has a valid CPF identification.

CPF Stands for “Cadastro de Pessoas Físicas” or “Registry of Individuals”.
It is similar to the “Social Security” number adopted in the US, and it is
used as a type of universal identifier in Brazil.

```php
use Torugo\PropertyValidator\Attributes\Validators\Strings\IsCpf;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description           |
| :------------- | :----- | :-------------------- |
| `errorMessage` | string | Custom error message. |

#### Examples <!-- omit in toc -->

```php
#[IsCpf()]
public $cpf = '88479747048';
// Valid

#[IsCpf()]
public $cpf = '532.625.750-54';
// Valid, this is the default format

#[IsCpf()]
public $cpf = '532 625 750 (54)';
// Valid, it removes non numerical characters

#[IsCpf()]
public $cpf = '532.625.750-55';
// Invalid verification digit

#[IsCpf()]
public $cpf = '53.625.750-54';
// Invalid length

#[IsCpf()]
public $cpf = '532.625.750-541';
// Invalid length
```

> [!IMPORTANT]
> The CPF numbers above were generated randomly using [this tool](https://www.4devs.com.br/gerador_de_cpf).  
> If one of them belongs to you, please send me a request and I will remove it immediately.

---

### IsEmail

Validates whether a string has a valid email structure.

```php
use Torugo\PropertyValidator\Attributes\Validators\Strings\IsEmail;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description           |
| :------------- | :----- | :-------------------- |
| `errorMessage` | string | Custom error message. |

#### Examples <!-- omit in toc -->

```php
#[IsEmail()]
public string $email = "foo@bar.com"; // valid

#[IsEmail()]
public string $email = "foo+bar@bar.com"; // valid

#[IsEmail()]
public mixed $email = "hans@m端ller.com"; // invalid

#[IsEmail()]
public mixed $email = "wrong()[],:;<>@@gmail.com"; // invalid
```

> [!TIP]
> Take a look at the [tests](./tests/Integration/Validators/Strings/IsEmailTest.php) to see more of valid or invalid emails.

---

# IsIP

Validates whether a string is a valid IP address for both V4 and V6.

```php
use Torugo\PropertyValidator\Attributes\Validators\Strings\IsIP;
```

#### Parameters

| Parameter      | Type   | Description                                                       |
| :------------- | :----- | :---------------------------------------------------------------- |
| `version`      | int    | 4 for IPv4 or 6 for IPv6, any other value tries to validate both. |
| `errorMessage` | string | Custom error message.                                             |

#### Examples <!-- omit in toc -->

```php
#[IsIP(4)] // Only IPv4
public $ip1 = "127.0.0.1";

#[IsIP(6)] // Only IPv6
public $ip2 = "fe80::a6db:30ff:fe98:e946";

#[IsIP()] // Both
public $ip3 = "185.85.0.29";
```

---

### IsSemVer

Validates whether a version number follow the rules of semantic versioning [(SemVer)](https://semver.org).

```php
use Torugo\PropertyValidator\Attributes\Validators\Strings\IsSemVer;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description           |
| :------------- | :----- | :-------------------- |
| `errorMessage` | string | Custom error message. |

#### Examples <!-- omit in toc -->

```php
#[IsSemVer()]
public $version = "1.0.0"; // valid

#[IsSemVer()]
public $version = "1.0.0-beta.1"; // valid

#[IsSemVer()]
public $version = "1.0.0+20"; // valid

#[IsSemVer()]
public $version = "alpha.beta"; // invalid

#[IsSemVer()]
public $version = "1.0.0-alpha_beta"; // invalid

#[IsSemVer()]
public $version = "1.01.1"; // invalid
```

---

### IsTUID

Validates whether a string is a valid [TUID](https://github.com/vitor-hugo/util-php?tab=readme-ov-file#tuid-torugo-unique-id).

```php
use Torugo\PropertyValidator\Attributes\Validators\Strings\IsTUID;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description           |
| :------------- | :----- | :-------------------- |
| `errorMessage` | string | Custom error message. |

#### Examples <!-- omit in toc -->

```php
#[IsTUID()]
public $short = "UU5IM7L-TS0SQK0Y3101"; // valid

#[IsTUID()]
public $medium = "V6ZS389O-SMXM-TM0SQK0Y3116"; // valid

#[IsTUID()]
public $long = "VPD1QAMA-XBFK-AVF7SSP67-TL0SQK0Y311B"; // valid

#[IsTUID()]
public $uuid = "E8ABFEBA-C1FE-4491-8DFA-609C5EEF825B"; // invalid
```

---

### IsURL

Validates whether a string has a valid URL structure.

```php
use Torugo\PropertyValidator\Attributes\Validators\Strings\IsURL;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type                              | Description           |
| :------------- | :-------------------------------- | :-------------------- |
| `options`      | Torugo\TString\Options\UrlOptions | Validation options.   |
| `errorMessage` | string                            | Custom error message. |

#### Validation Options <!-- omit in toc -->

Default values:

```php
new UrlOptions(
    requireTld: true,
    requireProtocol: false, // expects the protocol to be present in the url
    requireValidProtocol: true, // requires one of the protocols bellow
    protocols: ["http", "https", "ftp"], // required protocols
    requireHost: true,
    requirePort: false,
    allowUnderscores: false,
    allowTrailingDot: false,
    allowProtocolRelativeUrls: false,
    allowFragments: true,
    allowQueryComponents: true,
    allowAuth: true,
    allowNumericTld: false,
    allowWildcard: false,
    validateLength: true,
);
```

#### Examples <!-- omit in toc -->

```php

///
/// VALID
///
#[IsUrl()]
public $url = 'foobar.com';

#[IsUrl()]
public $url = 'www.foobar.com';

#[IsUrl()]
public $url = 'http://www.foobar.com/';

#[IsUrl()]
public $url = 'http://127.0.0.1/';

#[IsUrl()]
public $url = 'http://10.0.0.0/';

#[IsUrl()]
public $url = 'http://189.123.14.13/';

#[IsUrl()]
public $url = 'http://duckduckgo.com/?q=%2F';

///
/// INVALID
///
#[IsUrl()]
public $url = 'http://www.foobar.com:0/';

#[IsUrl()]
public $url = 'http://www.foobar.com:70000/';

#[IsUrl()]
public $url = 'http://www.foobar.com:99999/';

#[IsUrl()]
public $url = 'http://www.-foobar.com/';

#[IsUrl()]
public $url = 'http://www.foobar-.com/';
```

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

### Matches

Performs a regular expression match on property's value

```php
use Torugo\PropertyValidator\Attributes\Validators\Strings\Matches;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description                                   |
| :------------- | :----- | :-------------------------------------------- |
| `pattern`      | string | The regex pattern to search for, as a string. |
| `errorMessage` | string | Custom error message.                         |

#### Examples <!-- omit in toc -->

```php
#[Matches("/^#(?:[0-9a-fA-F]{3}){1,2}$/")]
public $color = "#0ABAB5";

#[Matches("\d{5}([ \-]\d{4})?")]
public mixed $zip = "98101";

#[Matches("/<\/?[\w\s]*>|<.+[\W]>/")]
public $tag = "<h1>Torugo</h2>";
```

---

### MaxLength

Validates if the length of a string is lesser than or equal to a maximum parameter.

```php
use Torugo\PropertyValidator\Attributes\Validators\Strings\MaxLength;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description                               |
| :------------- | :----- | :---------------------------------------- |
| `max`          | int    | Maximum acceptable length. (must be >= 1) |
| `errorMessage` | string | Custom error message.                     |

#### Examples <!-- omit in toc -->

```php
#[MaxLength(60)]
public $text = "They may take our lives, but they'll never take our freedom!"; // valid

#[MaxLength(64)]
public $password = "9a2f534"; // invalid

// In order to accept empty strings you
// will have to use IsOptional attribute
#[IsOptional()]
#[MaxLength(10)]
public $prop1 = ""; // valid

#[MaxLength(10)]
public $prop2 = ""; // invalid
```

---

### MinLength

| Parameter      | Type   | Description                               |
| :------------- | :----- | :---------------------------------------- |
| `min`          | int    | Minimum acceptable length. (must be >= 1) |
| `errorMessage` | string | Custom error message.                     |

#### Examples <!-- omit in toc -->

```php
#[MinLength(12)]
public $text = "Nunc placerat a turpis vitae."; // valid

#[MinLength(10)]
public $prop = "My Prop"; // invalid, lesser than min arg

#[MinLength(0)]
public $prop = ""; // valid, makes no sense, but is valid. Why not use only 'IsString()'?
```

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

<!-- MARK: Handlers -->

# Handlers

Set of attributes that modify the value of a property and do not validate
the value, the objective is to transform/manipulate them in some way.

When the type of the value is incorrect, the handlers should do nothing,
so they normally do not throw any exceptions in this cases.

Some handlers require the property to be of a certain type, usually `mixed`,
therefore they can throw [`InvalidTypeException`](#error-handling).

## Common

### CopyFrom

Copies the value of another property in the same class.

```php
use Torugo\PropertyValidator\Attributes\Handlers\Common\CopyFrom;
```

#### Parameters <!-- omit in toc -->

| Parameter | Type   | Description                                                         |
| :-------- | :----- | :------------------------------------------------------------------ |
| `target`  | string | Name of the property in the same class, whose value will be copied. |

> [!IMPORTANT]
> Throws `InvalidArgumentException` if the target properthy does not exists.

#### Example <!-- omit in toc -->

```php
public $target = "My String";

#[CopyFrom("target")]
public $copy; // "My String"
```

---

## Convertions

### Explode

`Explode` is an alias to [`Split`](#split) handler.

```php
use Torugo\PropertyValidator\Attributes\Handlers\Convertions\Explode;
```

---

### Implode

`Implode` is an alias to [`Join`](#join) handler.

```php
use Torugo\PropertyValidator\Attributes\Handlers\Convertions\Implode;
```

---

### Join

Converts an array to a string by recursively joining the values
​​by placing a separator between them.

> [!NOTE]
> This handler requires the property to be declared as `mixed`,
> otherwise `InvalidTypeException` will be thrown.

```php
use Torugo\PropertyValidator\Attributes\Handlers\Convertions\Join;
```

#### Parameters <!-- omit in toc -->

| Parameter      | Type   | Description                                            |
| :------------- | :----- | :----------------------------------------------------- |
| `separator`    | string | To be placed between each array value. (Default `''`)  |
| `includeKeys`  | bool   | Include key before each array value. (Default `false`) |
| `keySeparator` | string | To be placed between the key and value. (Default `: `) |

#### Examples <!-- omit in toc -->

```php
#[Join()]
public $alpha = ["A", "B", "C", ["D", "E", "F"]];
// "ABCDEF" -> Is recursively
// Using the native PHP implode function the result would be "ABCArray"

#[Join(".")]
public $ip = ["123", "456", "789", "001"];
// "123.456.789.001"

#[Implode(" ")]
public $name = ["firstName" => "Conceição", "lastName" => "Evaristo"];
// "Conceição Evaristo"

#[Join(" - ", true, ": ")]
public $form = ["firstName" => "José", "lastName" => "Alencar"];
// "firstName: José - lastName: Alencar"
```

---

### Split

Converts a string to an array of strings each of which is a substring of
it on boundaries formed by the string separator.

> [!NOTE]
> This handler requires the property to be declared as `mixed`,
> otherwise `InvalidTypeException` will be thrown.

```php
use Torugo\PropertyValidator\Attributes\Handlers\Convertions\Split;
```

#### Parameters <!-- omit in toc -->

| Parameter   | Type   | Description              |
| :---------- | :----- | :----------------------- |
| `separator` | string | The boundary string.     |
| `limit`     | int*   | (Default: `PHP_INT_MAX`) |

> \* If limit is set and positive, the returned array will contain a maximum
> of limit elements with the last element containing the rest of string.
> If the limit parameter is negative, all components except the last - limit
> are returned. If the limit parameter is zero, then this is treated as 1.

#### Examples <!-- omit in toc -->

```php
#[Split(" ")]
public mixed $lipsum = "Ut rutrum mauris eget pulvinar";
// ["Ut", "rutrum", "mauris", "eget", "pulvinar"]

#[Split(".")]
public mixed $ip = "123.456.789.001";
// ["123", "456", "789", "001"]

#[Split("-", 4)]
public mixed $serial = "lvnr-MHba-hb6G-Mezq-8I55-eyZv";
// ["lvnr", "MHba", "hb6G", "Mezq-8I55-eyZv"]

#[Split("-", -2)]
public mixed $str = "lvnr-MHba-hb6G-Mezq-8I55-eyZv";
// ["lvnr", "MHba", "hb6G", "Mezq"]

#[Split("-", -2)]
public string $str = "lvnr-MHba-hb6G-Mezq-8I55-eyZv";
// throws InvalidTypeException, property must be mixed
```

---

## Strings

### Append

Concatenates a string at the end of the property value.

```php
use Torugo\PropertyValidator\Attributes\Handlers\Strings\Append;
```

#### Parameters <!-- omit in toc -->

| Parameter | Type   | Description               |
| :-------- | :----- | :------------------------ |
| `append`  | string | String to be concatenated |

#### Examples <!-- omit in toc -->

```php
#[Append(".")]
public $phrase = "My phrase"; // "My phrase."

#[Append("!")]
#[Append("?")]
public $str = "My String"; // "My String!?"
```

---

### PasswordHash

Generates a new password hash using a strong one-way hashing algorithm.  
Uses PHP [`password_hash()`](https://www.php.net/manual/en/function.password-hash.php) function.

```php
use Torugo\PropertyValidator\Attributes\Handlers\Strings\PasswordHash;
```

#### Parameters <!-- omit in toc -->

| Parameter | Type              | Description                                                                                                                                                                                                               |
| :-------- | :---------------- | :------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| `algo`    | int\|string\|null | A password algorithm constant denoting the algorithm to use when hashing the password.                                                                                                                                    |
| `options` | string            | An associative array containing options. See the password algorithm constants for documentation on the supported options for each algorithm. If omitted, a random salt will be created and the default cost will be used. |

#### Examples <!-- omit in toc -->

```php
#[PasswordHash()]
public mixed $pass1 = "5up3rStr0ngP4ssw0rd!";
// $2y$10$SliJ/ky9gIr0XyAJmnjtM.tG94h6wXUy0BSeMsuMMxXs9aHjWW5HO

#[PasswordHash(PASSWORD_ARGON2I)]
public mixed $pass2 = "tKxSYVBH+Te2rb5nUWN87&";
// $argon2i$v=19$m=65536,t=4,p=1$NWNzR3JwSmlyYktQVTBELw$uCfkmLa7EJTzNzKySOxjGeN44RyQmJn8hFyNBF1nW7A

#[PasswordHash(PASSWORD_BCRYPT, ["cost" => 10])]
public mixed $pass3 = "LzM#KFSqk9Uwb7TQsYA3JW";
// $2y$10$qsByI6OVsNgPS6TdKUs.Ve9hYml27ZRVdQV2WB1iZjhWSDhSbpVZS
```

---

### Prepend

Concatenates a string at the beginning of the property value.

```php
use Torugo\PropertyValidator\Attributes\Handlers\Strings\Prepend;
```

#### Parameters <!-- omit in toc -->

| Parameter | Type   | Description               |
| :-------- | :----- | :------------------------ |
| `prepend` | string | String to be concatenated |

#### Examples <!-- omit in toc -->

```php
#[Append(".")]
public $phrase = "My phrase"; // "My phrase."

#[Append("!")]
#[Append("?")]
public $str = "My String"; // "My String!?"
```

---

### SubString

Returns the portion of string specified by the offset and length parameters.  
Uses PHP [`substr()`](https://www.php.net/manual/en/function.substr.php) function.

```php
use Torugo\PropertyValidator\Attributes\Handlers\Strings\SubString;
```

#### Parameters <!-- omit in toc -->

| Parameter | Type        | Description                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     |
| :-------- | :---------- | :---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `offset`  | int         | If `offset` is non-negative, the returned string will start at the `offset`'th position in `string`, counting from zero. For instance, in the string ' `abcdef`', the character at position `0` is ' `a`', the character at position `2` is ' `c`', and so forth. If `offset` is negative, the returned string will start at the `offset`'th character from the end of `string`. If `string` is less than `offset` characters long, an empty string will be returned. Example #1 Using a negative `offset`                                                                                                                                      |
| `length`  | int or null | If `length` is given and is positive, the string returned will contain at most `length` characters beginning from `offset` (depending on the length of `string`). If `length` is given and is negative, then that many characters will be omitted from the end of `string` (after the start position has been calculated when a `offset` is negative). If `offset` denotes the position of this truncation or beyond, an empty string will be returned. If `length` is given and is `0`, an empty string will be returned. If `length` is omitted or `null`, the substring starting from `offset` until the end of the string will be returned. |

#### Examples <!-- omit in toc -->

```php
#[SubString(0, 3)]
public $var1 = "abcdef"; // returns "abc"

#[SubString(-1)]
public $var2 = "abcdef"; // returns "f"

#[SubString(0, -1)]
public $var3 = "abcdef"; // returns "abcde"

#[SubString(4, -4)]
public $var4 = "abcdef"; // returns an empty string 

#[SubString(2, -1)]
public $var4 = "abcdef"; // returns "cde"
```

---

### Replace

Replace all occurrences of the search string with the replacement string.

```php
use Torugo\PropertyValidator\Attributes\Handlers\Strings\Replace;
```

#### Parameters <!-- omit in toc -->

| Parameter | Type            | Description                                                                                                       |
| :-------- | :-------------- | :---------------------------------------------------------------------------------------------------------------- |
| `search`  | string or array | The value being searched for. An array may be used to designate multiple values.                                  |
| `replace` | string or array | The replacement value that replaces found search values. An array may be used to designate multiple replacements. |

#### Examples <!-- omit in toc -->

```php
#[Replace(" ", "_")]
public $under = "Underscore on spaces";
// "Underscore_on_spaces"

#[Replace(["+", "/", "="], ["-", "_", ""])]
public $b64 = "Vh9yB+XNo0cXfyfATY/bmw==";
// "Vh9yB-XNo0cXfyfATY_bmw"

#[Replace(" ", "")]
public $ipv6 = "2001 : 0000 : 130F : 0000 : 0000 : 09C0 : 876A : 130B";
// "2001:0000:130F:0000:0000:09C0:876A:130B"

#[Replace("A", "B")]
#[Replace("B", "C")]
#[Replace("C", "D")]
#[Replace("D", "E")]
public $cascade = "A";
// "E"

#[Replace(["<", ">"], [""])]
public $array = ["<A>", "<B>", "<C>", "<D>"];
// ["A", "B", "C", "D"];
```

---

### ToLowerCase

Converts a string or string elements in an array to lower case.

```php
use Torugo\PropertyValidator\Attributes\Handlers\Strings\ToLowerCase;
```

#### Examples <!-- omit in toc -->

```php
#[ToLowerCase()]
public string $email = "MYEMAIL@MYHOST.COM"; // myemail@myhost.com

#[ToLowerCase()]
public string $arr = ["A", ["B", ["C", "D"]]]; // ["a", ["b", ["c", "d"]]]
```

---

### ToTitleCase

Converts a string or string elements in an array to title case.

```php
use Torugo\PropertyValidator\Attributes\Handlers\Strings\ToTitleCase;
```

#### Parameters <!-- omit in toc -->

| Parameter                   | Type | Description                                                         |
| :-------------------------- | :--- | :------------------------------------------------------------------ |
| `fixRomanNumerals`          | bool | Keep roman numerals uppercased (up to 6 digits). (Default: `false`) |
| `fixPortuguesePrepositions` | bool | Keep portuguese prepositions in lowercase. (Default: `false`)       |

> To know more [visit](https://github.com/vitor-hugo/string-lib-php?tab=readme-ov-file#totitlecase).

#### Examples <!-- omit in toc -->

```php
#[ToTitleCase()]
public string $name = "ADA LOVELACE"; // Ada Lovelace

#[ToTitleCase(true)] // fix roman numerals
public string $name = "pope benedict xvi"; // Pope Benedict XVI

#[ToTitleCase(false, true)] // fix portuguese prepositions
public string $name = "NISE DA SILVEIRA"; // Nise da Silveira

#[ToTitleCase(true, true)] // both
public string $name = "XV DE PIRACICABA"; // XV de Piracicaba
```

---

### ToUpperCase

Converts a string or string elements in an array to upper case.

```php
use Torugo\PropertyValidator\Attributes\Handlers\Strings\ToUpperCase;
```

#### Examples <!-- omit in toc -->

```php
#[ToUpperCase()]
public string $title = "lord of the rings"; // LORD OF THE RINGS

#[ToUpperCase()]
public string $arr = ["a", ["b", ["c", "d"]]]; // ["A", ["B", ["C", "D"]]]
```

---

### Trim, LTrim and RTrim

Strip whitespace (or other characters) from the beginning and end of a string.

```php
use Torugo\PropertyValidator\Attributes\Handlers\Strings\Trim;
```

#### Characters parameter <!-- omit in toc -->

The stripped `characters` can be specified using the characters parameter.
Simply list all characters that you want to be stripped.
With `..` you can specify a range of characters.

#### Examples <!-- omit in toc -->

```php
#[Trim()]
public $default = "    String    "; // => "String"

#[Trim(" -=")]
public $especific = "--- String ==="; // => "String"

#[Trim("A..E")]
public $range = "ABCDEFGFEDCBA"; // => "FGF"
```

> [!NOTE]
> `LTrim` and `RTrim` works exactly in the same way.

---

# Setters

## SetDateTime

Sets the property's value as DateTime object or formatted string.

```php
use Torugo\PropertyValidator\Attributes\Setters\SetDateTime;
```

### Parameters <!-- omit in toc -->

| Parameter  | Type               | Description                                                                                                                       |
| :--------- | :----------------- | :-------------------------------------------------------------------------------------------------------------------------------- |
| `datetime` | string             | A date/time string. Valid formats are explained in Date and Time Formats.                                                         |
| `format`   | string\|null       | If provided, the value will be setted as a formatted string.                                                                      |
| `timezone` | DateTimeZone\|null | A DateTimeZone object representing the timezone of $datetime. If $timezone is omitted or null, the current timezone will be used. |

### Examples <!-- omit in toc -->

```php
#[SetDateTime()]
public DateTime $dt1; // PHP DateTime object

#[SetDateTime("now", null, new DateTimeZone("America/Sao_Paulo"))]
public mixed $dt2; // PHP DateTime object

#[SetDateTime("now", "Y-m-d H:i:s", new DateTimeZone("America/Sao_Paulo"))]
public mixed $dt3; // String with custom date/time format
```

---

## SetFromCallback

Sets the property's value from a returned value of a function or class method.
This attribute wraps the PHP [`call_user_func_array`](https://www.php.net/manual/en/function.call-user-func-array.php) function.

```php
use Torugo\PropertyValidator\Attributes\Setters\SetFromCallback;
```

### Parameters

| Parameter  | Type          | Description                                               |
| :--------- | :------------ | :-------------------------------------------------------- |
| `callback` | string\|array | The callable to be called.                                |
| `args`     | array         | The parameters to be passed to the callback, as an array. |

> [!NOTE]
> If you want to call a method from a class, the method must be static.

### Examples

```php

function sum(int $n1, int $n2): int
{
    return $n1 + $n2;
}

class MathClass {
    // The method MUST be static
    public static function multiply(int $n1, int $n2): int
    {
        return $n1 * $n2;
    }
}

class MyDto
{
    // Call the native PHP 'rand' function, and pass the arguments 10 and 50
    #[SetFromCallback("rand", [10, 50])]
    public int $random;

    // Call the sum function declared above, passing 1 and 2 as arguments
    #[SetFromCallback("sum", [1, 2])]
    public int $sum;
    
    // Call the multiply method from the MathClass declared above,
    // passing 5 and 5 as arguments
    #[SetFromCallback([MathClass::class, "multiply"], [5, 5])]
    public int $mult;

    // Call a method from a class, in this case call the 'str' method
    // from the class itself.
    #[SetFromCallback([self::class, "str"])]
    public string $str = "";

    public static function str(): string
    {
        return "my string";
    }
}

```

---

## SetValueWhenEmpty

Sets a custom string value when property receives an empty string or a null value.

```php
use Torugo\PropertyValidator\Attributes\Setters\SetValueWhenNull;
```

### Parameters

| Parameter | Type   | Description                                                            |
| :-------- | :----- | :--------------------------------------------------------------------- |
| `value`   | String | The value to be setted when property receives an empty string or null. |

### Examples

```php
#[SetValueWhenEmpty("Default")]
public string $var1 = ""; // => "Default"

#[SetValueWhenEmpty("Custom")]
public ?string $var2 = null; // => "Custom"

#[SetValueWhenEmpty("Mixed")] 
public mixed $var3 = null; // => "Mixed"

#[SetValueWhenEmpty("Custom")] 
public string $var4 = "Value"; // => Nothing happens
```

---

## SetValueWhenNull

Sets a custom value when property receives a null value.

```php
use Torugo\PropertyValidator\Attributes\Setters\SetValueWhenNull;
```

### Parameters

| Parameter | Type  | Description                                         |
| :-------- | :---- | :-------------------------------------------------- |
| `value`   | mixed | The value to be setted when property receives null. |

### Examples

```php
#[SetValueWhenNull("")]
public ?string $str = null; // Will be setted to `""`

#[SetValueWhenNull(0)]
public ?int $int = null; // Will be setted to `0`

#[SetValueWhenNull([])]
public ?array $arr = null; // Will be setted to `[]`
```


---

# Custom Validators

To create a custom validator is required:

1. The validator must extends `Torugo\PropertyValidator\Abstract\Validator`;
2. Add the attribute `#[Attribute(Attribute::TARGET_PROPERTY)]` to the class;
3. Implement the method `public function validation(mixed $value): void`;

## Templates

### Simple validator <!-- omit in toc -->

```php
use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;

#[Attribute(Attribute::TARGET_PROPERTY)]
class MyValidator extends Validator
{
    public function validation(mixed $value): void
    {
        // Validate the data
    }
}
```

### Validator with arguments <!-- omit in toc -->

```php
use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;

#[Attribute(Attribute::TARGET_PROPERTY)]
class MyValidator extends Validator
{
    public function __construct(
        private $arg1,
        private $arg2,
        private ?string $errorMessage = null
    ) {
        parent::__construct($errorMessage);
    }

    public function validation(mixed $value): void
    {
        // Validate the data
    }
}
```

## Validator class

The `Validator` class gives to you:

**Properties**

| Property        | Type     | Description                                                             |
| --------------- | -------- | ----------------------------------------------------------------------- |
| `propertyName`  | `string` | The name of the property                                                |
| `propertyType`  | `string` | The type of the property, if not declared it will be considered "mixed" |
| `propertyValue` | `mixed`  | The value of the property                                               |

**Methods**


| Method                                                             | Description                                                                                                             |
| ------------------------------------------------------------------ | ----------------------------------------------------------------------------------------------------------------------- |
| `expectPropertyTypeToBe(array\|string $expected): void`            | Validates if the property type is the expected. (throws `InvalidTypeException`)                                         |
| `expectValueTypeToBe(array\|string $expected): void`               | Validates if the property value type is the expected. (throws `InvalidTypeException`)                                   |
| `hasAttribute(string $attrClass): bool`                            | Checks if the property has a specified attribute.                                                                       |
| `isNullable(): bool`                                               | Checks if the property is nullable.                                                                                     |
| `isUsingIsOptionalAttribute(): bool`                               | Checks if the property is using the `#[IsOptional()]` attribute.                                                        |
| `isUsingRequiredAttribute(): bool`                                 | Checks if the property is using the `#[IsRequired()]` attribute.                                                        |
| `throwInvalidTypeException(string $message, int $code = 0): never` | Throws `InvalidTypeException` using the validator's default message or the custom error message defined on constructor. |
| `throwValidationException(string $message, int $code = 0): never`  | Throws `ValidationException` using the validator's default message or the custom error message defined on constructor.  |

---

# Contribute

It is currently not open to contributions, I intend to make it available as soon as possible.


# License

This library is licensed under the MIT License - see the LICENSE file for details.
