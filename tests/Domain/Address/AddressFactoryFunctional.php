<?php

namespace App\Tests\Domain\Address;

use App\Domain\Address\Address;
use App\Domain\Address\Factory\AddressFactory;
use App\Domain\Address\Factory\CreateAddressDto;
use App\Domain\Address\Store\DTO\AddressDto;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AddressFactoryFunctional extends KernelTestCase
{
    /**
     * @test
     * @dataProvider createDataProvider
     */
    public function create(AddressDto $addressDto): void
    {
        self::bootKernel();
        $createAddressDto = new CreateAddressDto($addressDto);

        $container = static::getContainer();
        $addressFactory = $container->get(AddressFactory::class);

        $address = $addressFactory->create($createAddressDto);

        self::assertInstanceOf(Address::class, $address);
    }

    public static function createDataProvider(): array
    {
        return [
            [new AddressDto("Russia", "Kaluga", "Suvorova", "121a")],
        ];
    }

    /**
     * @test
     * @dataProvider negativeCreateDataProvider
     */
    public function negativeCreate(AddressDto $addressDto): void
    {
        self::expectException(\Exception::class);

        self::bootKernel();
        $createAddressDto = new CreateAddressDto($addressDto);

        $container = static::getContainer();
        $addressFactory = $container->get(AddressFactory::class);

        $addressFactory->create($createAddressDto);
    }

    public static function negativeCreateDataProvider(): array
    {
        return [
            [new AddressDto("", "Kaluga", "Suvorova", "121a")],
            [new AddressDto("Russia", "", "Suvorova", "121a")],
            [new AddressDto("Russia", "Kaluga", "", "121a")],
            [new AddressDto("Russia", "Kaluga", "Suvorova", "")],
        ];
    }
}