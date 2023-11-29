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
    public function create(CreateAddressDto $createAddressDto): void
    {
        self::bootKernel();

        $container = static::getContainer();
        $addressFactory = $container->get(AddressFactory::class);

        $address = $addressFactory->create($createAddressDto);

        self::assertInstanceOf(Address::class, $address);
    }

    public static function createDataProvider(): array
    {
        return [
            [new CreateAddressDto("Russia", "Kaluga", "Suvorova", "121a")],
        ];
    }

    /**
     * @test
     * @dataProvider negativeCreateDataProvider
     */
    public function negativeCreate(CreateAddressDto $createAddressDto): void
    {
        self::expectException(\Exception::class);

        self::bootKernel();

        $container = static::getContainer();
        $addressFactory = $container->get(AddressFactory::class);

        $addressFactory->create($createAddressDto);
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