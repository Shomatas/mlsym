<?php

namespace App\Tests\Domain\Validator\DataProvider;

trait NumericValidatorTestDataProviderTrait
{

    public static function validDP(): array
    {
        return [
            ["123"],
            [123],
            [123.23],
            ["123.32"],
            ["12e3"]
        ];
    }


    public static function invalidDP(): array
    {
        return [
            ["123a"],
            ["a123"],
            ["abacaba"],
            ["?.dsf23"],
            ["a123a"],
        ];
    }
}