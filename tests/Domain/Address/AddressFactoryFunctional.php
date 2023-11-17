<?php

namespace App\Tests\Domain\Address;

use App\Domain\Address\Address;
use App\Domain\Address\Store\DTO\AddressDto;
use App\Domain\Address\Store\Factory\AddressFactory;
use App\Domain\Address\Store\Factory\CreateAddressDto;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
            [new AddressDto("Russia", "Kaluga", "Suvorova", "")],
        ];
    }

    /**
     * @test
     * @dataProvider createDataProvider
     */
    public function negativeCreate(AddressDto $addressDto): void
    {
        self::expectException(\Exception::class);
        self::bootKernel();
        $createAddressDto = new CreateAddressDto($addressDto);

        $container = static::getContainer();
        $addressFactory = $container->get(AddressFactory::class);

        $address = $addressFactory->create($createAddressDto);
    }
}