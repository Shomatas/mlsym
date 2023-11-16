<?php

namespace App\Controller;

use App\Domain\User\Store\DTO\UserRegisterDTO;
use App\Domain\User\Store\GetUserInterface;
use App\Domain\User\User;
use App\Domain\User\UserRegistration;
use App\Store\User\GetUser;
use App\Store\User\SaveUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
class UsersController
{
    public function __construct(
        private GetUserInterface $userGetter
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
        #[MapRequestPayload] User $user
    ): Response
    {
        $userSaver = new SaveUser();
        $userRegistrar = new UserRegistration($userSaver);
        $userRegistrar->register($user);
        return new Response("Успешная регистрация", Response::HTTP_CREATED);
    }
}