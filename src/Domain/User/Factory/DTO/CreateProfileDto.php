<?php

namespace App\Domain\User\Factory\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateProfileDto
{
    public function __construct(
        #[Assert\NotBlank]
        public string $firstname = "",
        #[Assert\NotBlank]
        public string $lastname = "",
        #[Assert\NotBlank]
        public int $age = 0,
    )
    {

    }
}