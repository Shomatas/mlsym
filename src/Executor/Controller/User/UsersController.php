<?php

namespace App\Executor\Controller\User;

use App\Domain\Address\Store\DTO\PatchAddressDto;
use App\Domain\Exception\DomainException;
use App\Domain\User\Store\DTO\AddressRegisterDto;
use App\Domain\User\Store\DTO\PatchProfileDto;
use App\Domain\User\Store\DTO\PatchUserDto;
use App\Domain\User\Store\DTO\ProfileRegisterDto;
use App\Domain\User\Store\DTO\UserRegisterDTO;
use App\Domain\User\Store\GetUserInterface;
use App\Domain\User\Store\UserCollectionDtoMapperInterface;
use App\Domain\User\Store\UserDtoMapperInterface;
use App\Domain\User\UserPatcher;
use App\Domain\User\UserRegistration;
use App\Executor\Controller\User\DTO\PatchProfileRequestDto;
use App\Executor\Controller\User\DTO\PatchUserRequestDto;
use App\Executor\Controller\User\DTO\UserRegisterRequestDto;
use App\Executor\Controller\User\Factory\ResponseFactory;
use PHPUnit\Util\Json;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UsersController
{
    public function __construct(
        private GetUserInterface                 $userGetter,
        private UserRegistration                 $userRegistrar,
        private UserCollectionDtoMapperInterface $userCollectionDtoMapper,
        private UserDtoMapperInterface           $userDtoMapper,
        private ValidatorInterface               $validator,
        private ResponseFactory                  $responseFactory,
        private UserPatcher                      $userPatcher,
    )
    {
    }

    #[Route('/users')]
    public function getAllUsers(): Response
    {
        try {
            $userCollection = $this->userGetter->getAll();
        } catch (\Throwable $exception) {
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
        $validationResult = $this->getConstraintViolationListInterfaceFromValidationUserRegisterRequestDto($dto);
        if ($validationResult->count() > 0) {
            return $this->responseFactory->create($validationResult, Response::HTTP_BAD_REQUEST);
        }
        $avatar = $request->files->get("avatar");
        if (is_null($avatar)) {
            return $this->responseFactory->create("Отсутствует файл аватара", Response::HTTP_BAD_REQUEST);
        }
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
        } catch (DomainException $exception) {
            return $this->responseFactory->createResponseFromDomainException($exception);
        } catch (\Throwable $exception) {
            return $this->responseFactory->create($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->responseFactory->create("Успешная регистрация", Response::HTTP_CREATED);
    }

    private function getConstraintViolationListInterfaceFromValidationUserRegisterRequestDto(
        UserRegisterRequestDto $userRegisterRequestDto
    ): ConstraintViolationListInterface
    {
        $validationResult = $this->validator->validate($userRegisterRequestDto);
        $validationResult->addAll($this->validator->validate($userRegisterRequestDto->profile));
        $validationResult->addAll($this->validator->validate($userRegisterRequestDto->address));
        return $validationResult;
    }


    #[Route('/users/{id}', methods: ['GET'])]
    public function getUserById(
        Uuid $id,
    ): Response
    {
        try {
            $userDto = $this->userGetter->get($id);
        } catch (\Throwable $exception) {
            return new Response($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new Response(
            $this->userDtoMapper->mapToJson($userDto),
            Response::HTTP_OK,
            ["content-type" => "application/json"]
        );
    }

    #[Route('/users/{id}', methods: ['PATCH'])]
    public function patchUserById(
        Uuid $id,
        #[ValueResolver('patch_user_request_dto')] PatchUserRequestDto $patchUserRequestDto,
    ): Response
    {
        $constraintViolationList = $this->validator->validate($patchUserRequestDto);
        if ($constraintViolationList->count() > 0) {
            return new JsonResponse('Данные не валидны', Response::HTTP_BAD_REQUEST);
        }

        $patchUserDto = new PatchUserDto(
            $id,
            $patchUserRequestDto->login,
            $patchUserRequestDto->password,
            new PatchProfileDto(
                $patchUserRequestDto->patchProfileRequestDto->firstname,
                $patchUserRequestDto->patchProfileRequestDto->lastname,
                $patchUserRequestDto->patchProfileRequestDto->age,
            ),
            new PatchAddressDto(
                $patchUserRequestDto->patchAddressRequestDto->country,
                $patchUserRequestDto->patchAddressRequestDto->city,
                $patchUserRequestDto->patchAddressRequestDto->street,
                $patchUserRequestDto->patchAddressRequestDto->houseNumber,
            ),
            $patchUserRequestDto->email,
            $patchUserRequestDto->phone,
        );
        try {
            $this->userPatcher->patch($patchUserDto);
        } catch (DomainException $exception) {
            return $this->responseFactory->createResponseFromDomainException($exception);
        } catch (\Throwable $exception) {
            return $this->responseFactory->create($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return new JsonResponse($this->userGetter->get($id), Response::HTTP_CREATED);
    }
}