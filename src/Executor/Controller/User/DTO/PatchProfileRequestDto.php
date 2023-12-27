<?php

namespace App\Executor\Controller\User\DTO;

use App\common\Validator as CustomAssert;

readonly class PatchProfileRequestDto
{
    public function __construct(
        public mixed $firstname = null,
        public mixed $lastname = null,
        #[CustomAssert\Integer]
        public mixed $age = null,
    )
    {
    }
}