<?php

namespace App\Contracts;

use App\DTOs\NewUserDto;

interface RegisterUserContract
{
    public function __invoke(NewUserDto $data): void;
}
