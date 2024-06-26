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
- [Validating Attributes](#validating-attributes)
  - [Type Checkers](#type-checkers)
    - [IsBoolean](#isboolean)
    - [IsDateTime](#isdatetime)
    - [IsDouble](#isdouble)
    - [IsEnum](#isenum)
    - [IsFloat](#isfloat)
    - [IsInt](#isint)
    - [IsInteger](#isinteger)
    - [IsNumber](#isnumber)
    - [IsString](#isstring)
  - [Arrays](#arrays)
    - [ArrayContains](#arraycontains)
    - [ArrayNotContains](#arraynotcontains)
  - [Common](#common)
    - [IsOptional](#isoptional)
    - [IsRequired](#isrequired)
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
    public $email = '';

    #[IsRequired()]
    #[IsString()]
    #[Length(8, 100)]
    public $password = '';

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
$signInDto->email = 'email@host.com';
$signInDto->password = 'MySuperStrongPassword!';
$signInDto->keepConnected = true;

// Using method inside the class
$signInDto->validate();

// or passing the instantiated class
PropertyValidator::validate($signInDto);
```


# Validating Attributes

## Type Checkers

### IsBoolean
### IsDateTime
### IsDouble
### IsEnum
### IsFloat
### IsInt
### IsInteger
### IsNumber
### IsString


## Arrays

### ArrayContains
### ArrayNotContains


## Common

### IsOptional
### IsRequired


## Numbers

### IsDivisibleBy
### IsNegative
### IsPositive
### Max
### Min


## Strings

### Contains
### IsAlpha
### IsAlphanumeric
### IsBase64
### IsCnpj
### IsCpf
### IsEmail
### IsNumeric
### IsUrl
### Length
### MaxLength
### MinLength
### NotContains
### MatchRegex


# Contribute

It is currently not open to contributions, I intend to make it available as soon as possible.


# License

This library is licensed under the MIT License - see the LICENSE file for details.
