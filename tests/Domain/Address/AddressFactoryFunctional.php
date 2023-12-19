<?php

namespace App\Tests\Domain\Address;

use App\Domain\Address\Address;
use App\Domain\Address\Factory\AddressFactory;
use App\Domain\Address\Factory\CreateAddressDto;
use App\Tests\Domain\Address\DataProvider\AddressFactoryFunctionalDataProviderTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AddressFactoryFunctional extends KernelTestCase
{
    use AddressFactoryFunctionalDataProviderTrait;

    /**
     * @test
     * @dataProvider createDataProvider
     */
    public function create(CreateAddressDto $createAddressDto): void
    {
        $container = static::getContainer();
        $addressFactory = $container->get(AddressFactory::class);
        $address = $addressFactory->create($createAddressDto);
        self::assertInstanceOf(Address::class, $address);
    }

    /**
     * @test
     * @dataProvider negativeCreateDataProvider
     */
    public function negativeCreate(CreateAddressDto $createAddressDto): void
    {
        self::expectException(\Exception::class);
        $container = static::getContainer();
        $addressFactory = $container->get(AddressFactory::class);
        $addressFactory->create($createAddressDto);
    }
}