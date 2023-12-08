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

        $login = $request->get("login") ?? null;
        $password = $request->get("password") ?? null;
        $profile = [
            "firstname" => $request->get("profile")["firstname"] ?? null,
            "lastname" => $request->get("profile")["lastname"] ?? null,
            "age" => $request->get("profile")["age"] ?? null,
        ];
        $address = [
            "country" => $request->get("address")["country"] ?? null,
            "city" => $request->get("address")["city"] ?? null,
            "street" => $request->get("address")["street"] ?? null,
            "house_number" => $request->get("address")["house_number"] ?? null,
        ];
        $email = $request->get("email") ?? null;
        $phone = $request->get("phone") ?? null;

        return [new UserRegisterRequestDto(
            $login,
            $password,
            new ProfileRequestDto(
                $profile["firstname"],
                $profile["lastname"],
                $profile["age"],
            ),
            new AddressRequestDto(
                $address["country"],
                $address["city"],
                $address["street"],
                $address["house_number"],
            ),
            $email,
            $phone,
        )];
    }
}