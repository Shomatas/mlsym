<?php

namespace App\Executor\Controller\User\Factory;

use App\Domain\Exception\DomainException;
use App\Domain\Exception\SystemException;
use App\Domain\User\Exception\CreateUserException;
use App\Domain\User\Exception\SaveUserException;
use App\Domain\User\Exception\UserAuthException;
use App\Domain\User\Exception\UserValidationException;
use Symfony\Component\HttpFoundation\Response;

class ResponseFactory
{
    public function create(string $content, int $status, array $headers = [])
    {
        return new Response($content, $status, $headers);
    }

    public function createResponseFromDomainException(DomainException $exception): Response
    {
        if ($exception instanceof UserValidationException) {
            $violations = [];
            foreach ($exception->getViolationList() as $violation) {
                $violations[] = $violation->getMessage();
            }

            return new Response(json_encode($violations, JSON_UNESCAPED_UNICODE), Response::HTTP_BAD_REQUEST);
        }

        if ($exception instanceof CreateUserException) {
            return new Response("Во время создания пользователя произошла ошибка", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($exception instanceof SaveUserException) {
            return new Response("Ошибка добавления пользователя в систему", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($exception instanceof SystemException) {
            return new Response("Во время обработки запроса произошла системная ошибка", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($exception instanceof UserAuthException) {
            return new Response("Логин или пароль неверны");
        }

        return new Response("Неизвестная ошибка", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}