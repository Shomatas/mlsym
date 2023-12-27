<?php

namespace App\Tests\Domain\User\DataProvider;

use App\Domain\Address\Store\DTO\PatchAddressDto;
use App\Domain\User\Store\DTO\PatchProfileDto;
use App\Domain\User\Store\DTO\PatchUserDto;
use Symfony\Component\Uid\Uuid;

trait UserPatcherFunctionalDataProviderTrait
{
    public static function patchDataProvider(): array
    {
        return [
            'When login is changed' => [
                new PatchUserDto(
                    Uuid::fromString('5268389d-c41a-4946-83f6-afbe4bcb691f'),
                    login: 'paff'
                )
            ],
            'When password is changed' => [
                new PatchUserDto(
                    Uuid::fromString('a89d4d6e-6c81-43dd-8049-ba589e9959e4'),
                    password: '123'
                )
            ],
            'When profile is changed' => [
                new PatchUserDto(
                    Uuid::fromString('64a09af0-4a57-4f5a-9752-4aa12c744d23'),
                    profileDto: new PatchProfileDto('ilya', 'kosmynin', 27),
                ),
            ],
            'When address is changed' => [
                new PatchUserDto(
                    Uuid::fromString('5673e7fb-6e98-4741-824e-f9bf016750ff'),
                    addressDto: new PatchAddressDto('France', 'Paris', 'Komarova', '1'),
                ),
            ],
            'When email is changed' => [
                new PatchUserDto(
                    Uuid::fromString('a53907b2-c30e-4e5f-8a73-53d33e3f37fc'),
                    email: 'temp@mail.com',
                ),
            ],
            'When phone is changed' => [
                new PatchUserDto(
                    Uuid::fromString('c756235f-11b1-40b2-8273-5ae916528abd'),
                    phone: '+7(910)843-32-12',
                ),
            ],
        ];
    }

    public static function failedPatchDataProvider(): array
    {
        return [
            'When login is invalid' => [
                new PatchUserDto(
                    Uuid::fromString('b1fe8a67-4f92-43a6-9fff-f2425db11e82'),
                    login: '',
                )
            ],
            'When password is invalid' => [
                new PatchUserDto(
                    Uuid::fromString('b1fe8a67-4f92-43a6-9fff-f2425db11e82'),
                    password: '',
                )
            ],
            'When profile is invalid' => [
                new PatchUserDto(
                    Uuid::fromString('b1fe8a67-4f92-43a6-9fff-f2425db11e82'),
                    profileDto: new PatchProfileDto('', '', 12),
                )
            ],
            'When address is invalid' => [
                new PatchUserDto(
                    Uuid::fromString('b1fe8a67-4f92-43a6-9fff-f2425db11e82'),
                    addressDto: new PatchAddressDto('', '', '', ''),
                )
            ],
            'When email is invalid' => [
                new PatchUserDto(
                    Uuid::fromString('b1fe8a67-4f92-43a6-9fff-f2425db11e82'),
                    email: 'vano2001komarovmail.ru',
                )
            ],
            'When phone is invalid' => [
                new PatchUserDto(
                    Uuid::fromString('b1fe8a67-4f92-43a6-9fff-f2425db11e82'),
                    phone: '8541146032',
                )
            ],
        ];
    }
}