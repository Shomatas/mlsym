<?php

namespace App\Domain\User\Store\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class AvatarDto
{
    public function __construct(
        #[Assert\NotBlank]
        public string $pathToFile = "",
        #[Assert\NotBlank()]
        #[Assert\Regex("/^image\/(jpeg|png|gif)$/")]
        public string $mimeType = "",
    )
    {

    }
}