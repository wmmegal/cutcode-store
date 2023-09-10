<?php

namespace App\Contracts;

use App\DTOs\NewUserDto;
use App\Models\User;

interface RegisterUserContract
{
    public function __invoke(NewUserDto $data): User;
}
