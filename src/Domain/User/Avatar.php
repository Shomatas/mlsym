<?php

namespace App\Domain\User;

use Symfony\Component\Validator\Constraints as Assert;

class Avatar
{
    public function __construct(
        private string $pathToFile = "",
    )
    {

    }

    public function getPathToFile(): string
    {
        return $this->pathToFile;
    }

    public function setPathToFile(string $pathToFile): void
    {
        $this->pathToFile = $pathToFile;
    }



}