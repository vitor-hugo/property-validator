<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Handlers\Strings\Replace;

class ValidReplaceContract extends BaseValidationTestClass
{
    #[Replace(" ", "_")]
    public $under = "Underscore on spaces";

    #[Replace(["+", "/", "="], ["-", "_", ""])]
    public $b64 = "Vh9yB+XNo0cXfyfATY/bmw==";

    #[Replace(" ", "")]
    public $ipv6 = "2001 : 0000 : 130F : 0000 : 0000 : 09C0 : 876A : 130B";

    #[Replace("A", "B")]
    #[Replace("B", "C")]
    #[Replace("C", "D")]
    #[Replace("D", "E")]
    public $cascade = "A";

    #[Replace(["<", ">"], [""])]
    public $array = ["<A>", "<B>", "<C>", "<D>"];
}
