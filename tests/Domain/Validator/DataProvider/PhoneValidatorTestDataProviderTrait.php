<?php

namespace App\Tests\Domain\Validator\DataProvider;

trait PhoneValidatorTestDataProviderTrait
{

    public static function validDP(): array
    {
        return [
            ["89371260827"],
            ["+79371260827"],
            ["8 (937) 126 0827"],
            ["+7-(937)-126-08-27"],
        ];
    }


    public static function invalidDP(): array
    {
        return [
            ["-89371260827"],
            ["79-371260827"],
            ["8 )937( 126 0827"],
            ["+7-(937)-126-082-7"],
        ];
    }
}