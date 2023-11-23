<?php

namespace App\Domain\User;

use Symfony\Component\Validator\Constraints as Assert;

class Avatar
{
    public function __construct(
        #[Assert\NotBlank]
        private string $pathToFile = "",
        #[Assert\NotBlank()]
        #[Assert\Regex("/^image\/(jpeg|png|gif)$/")]
        private string $mimeType = "",
    )
    {

    }

    public function getPathToFile(): string
    {
        return $this->pathToFile;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }



}