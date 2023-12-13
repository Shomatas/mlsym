<?php

namespace App\Tests\Domain\Address\DataProvider;

use App\Domain\Address\Factory\CreateAddressDto;

trait AddressFactoryFunctionalDataProviderTrait
{

    public static function createDataProvider(): array
    {
        return [
            [new CreateAddressDto("Russia", "Kaluga", "Suvorova", "121a")],
        ];
    }
    public static function negativeCreateDataProvider(): array
    {
        return [
            [new CreateAddressDto("", "Kaluga", "Suvorova", "121a")],
            [new CreateAddressDto("Russia", "", "Suvorova", "121a")],
            [new CreateAddressDto("Russia", "Kaluga", "", "121a")],
            [new CreateAddressDto("Russia", "Kaluga", "Suvorova", "")],
        ];
    }
}