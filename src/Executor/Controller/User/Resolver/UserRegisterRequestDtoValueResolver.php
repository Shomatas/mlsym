<?php

namespace App\Executor\Controller\User\Resolver;

use App\Executor\Controller\User\DTO\AddressRequestDto;
use App\Executor\Controller\User\DTO\ProfileRequestDto;
use App\Executor\Controller\User\DTO\UserRegisterRequestDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsTargetedValueResolver;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

#[AsTargetedValueResolver("user_register_request_dto")]
class UserRegisterRequestDtoValueResolver implements ValueResolverInterface
{

    /**
     * @inheritDoc
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();
        if (!$argumentType) {
            return [];
        }

        return [new UserRegisterRequestDto(
            $request->get("login"),
            $request->get("password"),
            new ProfileRequestDto(
                $request->get("profile")["firstname"],
                $request->get("profile")["lastname"],
                $request->get("profile")["age"],
            ),
            new AddressRequestDto(
                $request->get("address")["country"],
                $request->get("address")["city"],
                $request->get("address")["street"],
                $request->get("address")["houseNumber"],
            ),
            $request->get("email"),
            $request->get("phone"),
        )];
    }
}