<?php

namespace App\Controller;

use App\Domain\User\Avatar;
use App\Domain\User\Factory\CreateUserDto;
use App\Domain\User\Factory\UserFactory;
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
        private UserFactory $userFactory,
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
        #[MapRequestPayload] CreateUserDto $dto,
            Request $request,
    ): Response
    {
        $avatar = $request->files->get("avatar");
        $avatarDto = new AvatarDto(
            "images/" . $avatar->getFilename() . $avatar->getClientOriginalName(),
            $avatar->getClientMimeType(),
        );

        $user = $this->userFactory->create($dto, $avatarDto);
        $userDto = UserDTO::createFromUser($user);

        $userRegisterDto = new UserRegisterDTO($userDto, $avatar->getPath() . '/' . $avatar->getFilename());
        $this->userRegistrar->register($userRegisterDto);
        return new Response("Успешная регистрация", Response::HTTP_CREATED);
    }
}