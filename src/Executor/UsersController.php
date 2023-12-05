<?php

namespace App\Executor;

use App\Executor\User\UserRegisterRequestDto;
use App\Domain\User\Store\DTO\AddressRegisterDto;
use App\Domain\User\Store\DTO\ProfileRegisterDto;
use App\Domain\User\Store\DTO\UserRegisterDTO;
use App\Domain\User\Store\GetUserInterface;
use App\Domain\User\Store\UserCollectionDtoMapperInterface;
use App\Domain\User\UserRegistration;
use App\Executor\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UsersController
{
    public function __construct(
        private GetUserInterface $userGetter,
        private UserRegistration $userRegistrar,
        private UserCollectionDtoMapperInterface $userCollectionDtoMapper,
        private ValidatorInterface $validator,
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
        #[ValueResolver("user_register_request_dto")] UserRegisterRequestDto $dto,
        Request $request
    ): Response
    {
        $validationResult = $this->validator->validate($dto);
        $validationResult->addAll($this->validator->validate($dto->profile));
        $validationResult->addAll($this->validator->validate($dto->address));

        if ($validationResult->count() > 0) {
            throw new ValidationException();
        }

        $avatar = $request->files->get("avatar");

        $userRegisterDto = new UserRegisterDTO(
            $dto->login,
            $dto->password,
            new ProfileRegisterDto($dto->profile->firstname, $dto->profile->lastname, $dto->profile->age),
            new AddressRegisterDto($dto->address->country, $dto->address->city, $dto->address->street, $dto->address->houseNumber),
            $dto->email,
            $dto->phone,
            $avatar->getRealpath(),
            $avatar->getClientMimeType(),
        );

        $this->userRegistrar->register($userRegisterDto);
        return new Response("Успешная регистрация", Response::HTTP_CREATED);
    }
}