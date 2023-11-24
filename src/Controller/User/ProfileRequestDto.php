<?php

namespace App\Controller\User;

use Symfony\Component\Validator\Constraints as Assert;

readonly class ProfileRequestDto
{
    public function __construct(
        #[Assert\NotBlank()]
        public mixed $firstname = null,
        #[Assert\NotBlank()]
        public mixed $lastname = null,
        #[Assert\NotBlank()]
        public mixed $age = null,
    )
    {

    }
}