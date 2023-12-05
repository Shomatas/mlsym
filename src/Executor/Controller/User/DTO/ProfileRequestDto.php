<?php

namespace App\Executor\Controller\User\DTO;

use App\common\Validator as CustomAssert;
use Symfony\Component\Validator\Constraints as Assert;

readonly class ProfileRequestDto
{
    public function __construct(
        #[Assert\NotBlank()]
        public mixed $firstname = null,
        #[Assert\NotBlank()]
        public mixed $lastname = null,
        #[Assert\NotBlank()]
        #[CustomAssert\Integer]
        public mixed $age = null,
    )
    {

    }
}