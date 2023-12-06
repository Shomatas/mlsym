<?php

namespace App\Executor\Controller\User;

use App\Domain\User\Exception\UserValidationException;
use App\Domain\User\Store\DTO\AddressRegisterDto;
use App\Domain\User\Store\DTO\ProfileRegisterDto;
use App\Domain\User\Store\DTO\UserRegisterDTO;
use App\Domain\User\Store\GetUserInterface;
use App\Domain\User\Store\UserCollectionDtoMapperInterface;
use App\Domain\User\UserRegistration;
use App\Executor\Controller\User\DTO\UserRegisterRequestDto;
use App\Executor\Controller\User\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UsersController
{
    public function __construct(
        private GetUserInterface                 $userGetter,
        private UserRegistration                 $userRegistrar,
        private UserCollectionDtoMapperInterface $userCollectionDtoMapper,
        private ValidatorInterface               $validator,
    )
    {
    }

    #[Route('/users')]
    public function getAllUsers(): Response
    {
        try {
            $userCollection = $this->userGetter->getAll();
        } catch(\Throwable $exception) {
            return new Response($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new Response(
            $this->userCollectionDtoMapper->mapToJson($userCollection),
            Response::HTTP_OK,
            ["content-type" => "application/json"],
        );
    }

    #[Route('/users/registration', methods: ['POST'])]
    public function register(
        #[ValueResolver("user_register_request_dto")] UserRegisterRequestDto $dto,
        Request                                                              $request
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

        try {
            $this->userRegistrar->register($userRegisterDto);
        } catch (UserValidationException $exception) {
            $response = [];
            foreach ($exception->getViolationList() as $violation) {
                $response[] = $violation->getMessage();
            }
            return new Response(json_encode($response, JSON_UNESCAPED_UNICODE), Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $exception) {
            return new Response($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new Response("Успешная регистрация", Response::HTTP_CREATED);
    }
}