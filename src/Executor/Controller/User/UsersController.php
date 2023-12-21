<?php

namespace App\Executor\Controller\User;

use App\Domain\Exception\DomainException;
use App\Domain\User\Store\DTO\AddressRegisterDto;
use App\Domain\User\Store\DTO\ProfileRegisterDto;
use App\Domain\User\Store\DTO\UserAuthorizationDto;
use App\Domain\User\Store\DTO\UserRegisterDTO;
use App\Domain\User\Store\GetUserInterface;
use App\Domain\User\Store\UserCollectionDtoMapperInterface;
use App\Domain\User\Store\UserDtoMapperInterface;
use App\Domain\User\UserAuthInspector;
use App\Domain\User\UserRegistration;
use App\Executor\Controller\User\DTO\UserAuthRequestDto;
use App\Executor\Controller\User\DTO\UserRegisterRequestDto;
use App\Executor\Controller\User\Factory\ResponseFactory;
use App\Store\User\UserDtoMapper;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Routing\Annotation\Route;
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
        private UserAuthInspector                $userAuthInspector,
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

    #[Route("/users/auth", methods: ["POST"])]
    public function auth(
        #[ValueResolver("user_auth_request_dto")] UserAuthRequestDto $userAuthRequestDto,
    ): Response
    {
        $resultValidation = $this->validator->validate($userAuthRequestDto);
        if ($resultValidation->count() > 0) {
            return $this->responseFactory->create($resultValidation, Response::HTTP_BAD_REQUEST);
        }
        $userAuthDto = new UserAuthorizationDto(
            $userAuthRequestDto->login,
            $userAuthRequestDto->password,
        );
        try {
            $userDto = $this->userAuthInspector->auth($userAuthDto);
        } catch (DomainException $exception) {
            return $this->responseFactory->createResponseFromDomainException($exception);
        } catch (\Throwable $exception) {
            return $this->responseFactory->create($exception->getMessage(), $exception->getCode());
        }
        return $this->responseFactory->create(
            $this->userDtoMapper->mapToJson($userDto),
            Response::HTTP_OK,
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
}