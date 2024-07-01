<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Strings\Contracts\ValidIsEmailContract;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group('Validators')]
#[Group('Strings')]
#[Group('IsEmail')]
#[TestDox('IsEmail - String Validator')]
class IsEmailTest extends TestCase
{
    public ValidIsEmailContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidIsEmailContract;
    }


    #[TestDox("Should be valid")]
    public function testShouldBeValid()
    {
        $valid = [
            'foo@bar.com',
            'x@x.au',
            'foo@bar.com.au',
            'foo+bar@bar.com',
            'hans.m端ller@test.com',
            'test123+ext@gmail.com',
            'some.name.midd.leNa.me.and.locality+extension@GoogleMail.com',
            '"foobar"@example.com',
            'test@gmail.com',
            'test.1@gmail.com',
            'test@1337.com',
        ];

        foreach ($valid as $email) {
            $this->stub->email = $email;
            $this->assertTrue($this->stub->validate());
        }
    }


    #[TestDox("Should throw ValidationException on invalid emails")]
    public function testShouldBeInvalid()
    {
        $invalid = [
            '',
            'hans@m端ller.com',
            'test|123@m端ller.com',
            'invalidemail@',
            'invalid.com',
            '@invalid.com',
            'foo@bar.com.',
            'foo@_bar.com',
            'somename@g m a i l.com',
            'foo@bar.co.uk.',
            'somename@ｇｍａｉｌ.com',
            'test1@invalid.co m',
            'test2@invalid.co m',
            'test3@invalid.co m',
            'test4@invalid.co m',
            'test5@invalid.co m',
            'test6@invalid.co m',
            'test7@invalid.co m',
            'test8@invalid.co m',
            'test9@invalid.co m',
            'test10@invalid.co m',
            'test11@invalid.co m',
            'test12@invalid.co　m',
            'test13@invalid.co　m',
            'multiple..dots@stillinvalid.com',
            'test123+invalid! sub_address@gmail.com',
            'gmail...ignores...dots...@gmail.com',
            'ends.with.dot.@gmail.com',
            'multiple..dots@gmail.com',
            'wrong()[]",:;<>@@gmail.com',
            '"wrong()[]",:;<>@@gmail.com',
            'username@domain.com�',
            'username@domain.com©',
            'nbsp test@test.com',
            'nbsp_test@te st.com',
            'nbsp_test@test.co m',
        ];

        foreach ($invalid as $email) {
            $this->stub->email = $email;

            try {
                $this->stub->validate();
            } catch (\Throwable $th) {
                $this->assertEquals("Torugo\PropertyValidator\Exceptions\ValidationException", $th::class);
                $this->assertEquals("The email '$email' is not valid.", $th->getMessage());
            }
        }
    }


    #[TestDox("Should throw ValidationException with custom message")]
    public function testShouldThrowValidationErrorWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Invalid email!!!");
        $this->stub->otherEmail = "'@invalid.com'";
        $this->stub->validate();
    }
}
