<?php

namespace App\Domain\User\Store\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class PatchProfileDto
{
    public function __construct(
        #[Assert\Length(min: 1)]
        public ?string $firstname = null,
        #[Assert\Length(min: 1)]
        public ?string $lastname = null,
        public ?int $age = null,
    ) {}
}