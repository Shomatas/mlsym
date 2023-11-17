<?php

namespace App\Controller;

use App\Domain\User\Factory\UserRegistrationFactory;
use App\Domain\User\Store\DTO\UserDTO;
use App\Domain\User\Store\GetUserInterface;
use App\Domain\User\Store\SaveUserInterface;
use App\Domain\User\UserRegistration;
use App\Store\User\SaveUser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
class UsersController
{
    public function __construct(
        private GetUserInterface $userGetter,
        private UserRegistration $userRegistrar,
    )
    {
    }
    #[Route('/users')]
    public function getAllUsers(): Response
    {
        return new Response(
            json_encode($this->userGetter->getAll(), JSON_UNESCAPED_UNICODE),
            Response::HTTP_OK,
            ["content-type" => "application/json"],
        );
    }

    #[Route('/users/registration', methods: ['POST'])]
    public function register(
        #[MapRequestPayload] UserDTO $userDto
    ): Response
    {
        $this->userRegistrar->register($userDto);
        return new Response("Успешная регистрация", Response::HTTP_CREATED);
    }
}