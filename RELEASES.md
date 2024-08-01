# Release History <!-- omit in toc -->

- [1.2.0](#120)
- [1.1.0 (Jul 08 2024)](#110-jul-08-2024)
- [1.0.0 (Jul 04 2024)](#100-jul-04-2024)

# 1.2.0

- Adding **IsEqualTo** validator.
- Some code refactoring. 

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
