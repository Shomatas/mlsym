<?php

namespace App\Executor\Controller\User\Resolver;

use App\Executor\Controller\User\DTO\PatchAddressRequestDto;
use App\Executor\Controller\User\DTO\PatchProfileRequestDto;
use App\Executor\Controller\User\DTO\PatchUserRequestDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsTargetedValueResolver;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

#[AsTargetedValueResolver("patch_user_request_dto")]
class PatchUserRequestDtoValueResolver implements ValueResolverInterface
{

    /**
     * @inheritDoc
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (!$argument->getType()) {
            return [];
        }
        $login = $request->get("login") ?: null;
        $password = $request->get("password") ?: null;
        $profile = new PatchProfileRequestDto(
            $request->get("profile[firstname]") ?: null,
            $request->get("profile[lastname]") ?: null,
            $request->get("profile[age]") ?: null,
        );
        $address = new PatchAddressRequestDto(
            $request->get("address[country]") ?: null,
            $request->get("address[city]") ?: null,
            $request->get("address[street]") ?: null,
            $request->get("address[house_number]") ?: null,
        );
        $email = $request->get("email") ?: null;
        $phone = $request->get('phone') ?: null;

        return [
            new PatchUserRequestDto(
                $login,
                $password,
                $profile,
                $address,
                $email,
                $phone,
            )
        ];
    }
}