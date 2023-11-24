<?php

namespace App\Controller;

use App\Controller\User\UserRegisterRequestDto;
use App\Domain\Address\Address;
use App\Domain\User\Profile;
use App\Domain\User\Store\DTO\AvatarDto;
use App\Domain\User\Store\DTO\UserDTO;
use App\Domain\User\Store\DTO\UserRegisterDTO;
use App\Domain\User\Store\GetUserInterface;
use App\Domain\User\Store\UserCollectionDtoMapperInterface;
use App\Domain\User\UserRegistration;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class UsersController
{
    public function __construct(
        private GetUserInterface $userGetter,
        private UserRegistration $userRegistrar,
        private UserCollectionDtoMapperInterface $userCollectionDtoMapper,
    )
    {
    }
    #[Route('/users')]
    public function getAllUsers(): Response
    {
        $userCollection = $this->userGetter->getAll();

        return new Response(
            $this->userCollectionDtoMapper->mapToJson($userCollection),
            Response::HTTP_OK,
            ["content-type" => "application/json"],
        );
    }

    #[Route('/users/registration', methods: ['POST'])]
    public function register(
        #[MapRequestPayload] UserRegisterRequestDto $dto,
        Request $request,
    ): Response
    {
        $avatar = $request->files->get("avatar");

        $userRegisterDto = new UserRegisterDTO(
            $dto->login,
            $dto->password,
            new Profile($dto->profile->firstname, $dto->profile->lastname, $dto->profile->age),
            new Address($dto->address->country, $dto->address->city, $dto->address->street, $dto->address->houseNumber),
            $dto->email,
            $dto->phone,
            $avatar->getRealpath(),
            $avatar->getClientMimeType(),
        );

        $this->userRegistrar->register($userRegisterDto);
        return new Response("Успешная регистрация", Response::HTTP_CREATED);
    }
}