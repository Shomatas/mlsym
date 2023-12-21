<?php

namespace App\Executor\Controller\User\Resolver;

use App\Executor\Controller\User\DTO\UserAuthRequestDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsTargetedValueResolver;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

#[AsTargetedValueResolver("user_auth_request_dto")]
class UserAuthRequestDtoValueResolver implements ValueResolverInterface
{

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();
        if (!$argumentType) {
            return [];
        }

        $login = $request->get("login") ?? null;
        $password = $request->get("password") ?? null;

        return [
            new UserAuthRequestDto(
                $login,
                $password,
            ),
        ];
    }
}