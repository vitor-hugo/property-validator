# Release History <!-- omit in toc -->

- [1.8.0 (Jan 23 2025)](#180-jan-23-2025)
- [1.7.0 (Jan 23 2025)](#170-jan-23-2025)
- [1.6.1 (Oct 01 2024)](#161-oct-01-2024)
- [1.6.0 (Sep 25 2024)](#160-sep-25-2024)
- [1.5.0 (Aug 12 2024)](#150-aug-12-2024)
- [1.4.2 (Aug 12 2024)](#142-aug-12-2024)
- [1.4.1 (Aug 02 2024)](#141-aug-02-2024)
- [1.4.0 (Aug 02 2024)](#140-aug-02-2024)
- [1.3.0 (Aug 02 2024)](#130-aug-02-2024)
- [1.2.1 (Aug 01 2024)](#121-aug-01-2024)
- [1.2.0 (Jul 31 2024)](#120-jul-31-2024)
- [1.1.0 (Jul 08 2024)](#110-jul-08-2024)
- [1.0.0 (Jul 04 2024)](#100-jul-04-2024)

# 1.8.0 (Jan 23 2025)

- Adding the validator 'IsTUID'

# 1.7.0 (Jan 23 2025)

- Adding the handler 'SubString'

# 1.6.1 (Oct 01 2024)

- Fixing a bug in the 'IsDateTime' validator, where an exception was thrown
  when the property received a PHP DateTime object.

# 1.6.0 (Sep 25 2024)

- Adding the setter 'SetValueWhenNull'

# 1.5.0 (Aug 12 2024)

- Adding the setter 'SetFromCallback'.

# 1.4.2 (Aug 12 2024)

- Creating a new attributes category called 'Setters'.
- Moving attribute 'SetDateTime' to the new 'Setters' category.

---

# 1.4.1 (Aug 02 2024)

- Fixing `Trim()`, `LTrim()` and `RTrim()` default charaters to trim.

---

# 1.4.0 (Aug 02 2024)

- Adding **CopyFrom** handler.
- Adding **SetDateTime** handler.

---

# 1.3.0 (Aug 02 2024)

- Adding **PasswordHash** validator.

---

# 1.2.1 (Aug 01 2024)

- Setting a null/empty value for non initialized properties.

---

# 1.2.0 (Jul 31 2024)

- Adding **IsEqualTo** validator.
- Some code refactoring. 

---

# 1.1.0 (Jul 08 2024)

- Adding **MaxDateTime** validator.
- Adding **MinDateTime** validator.
- Simplifying the 'getPropertyType' method on TypeTrait.
- Method normalizeType on TypeTrait now check if type name is a native PHP class.
- Adding a the method 'hasAttribute' on PropertyTrait.

---

# 1.0.0 (Jul 04 2024)

Initial production ready version.

<h3>Validators</h3>

- ArrayContains
- ArrayKeyExists
- ArrayMaxSize
- ArrayMinSize
- ArrayNotContains
- Contains
- IsAlpha
- IsAlphanumeric
- IsArray
- IsBase64
- IsBoolean
- IsCnpj
- IsCpf
- IsDateTime
- IsDivisibleBy
- IsDouble
- IsEmail
- IsEnum
- IsFloat
- IsInt
- IsInteger
- IsNegative
- IsNumeric
- IsOptional
- IsPositive
- IsRequired
- IsSemVer
- IsString
- IsURL
- Length
- Matches
- Max
- MaxLength
- Min
- MinLength
- NotContains
- Range
- SameAs


<h3>Handlers</h3>

- Explode
- Implode
- Join
- Split
- Append
- LTrim
- Prepend
- Replace
- RTrim
- ToLowerCase
- ToTitleCase
- ToUpperCase
- Trim
