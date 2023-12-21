<?php

namespace App\Executor\Controller\User\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UserAuthRequestDto
{
    public function __construct(
        #[Assert\NotBlank]
        public mixed $login = null,
        #[Assert\NotBlank]
        public mixed $password = null,
    )
    {
    }
}