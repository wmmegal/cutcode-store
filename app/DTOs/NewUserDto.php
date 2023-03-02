<?php

namespace App\DTOs;


use Illuminate\Http\Request;
use  App\Support\Traits\Makeable;

class NewUserDto
{
    use Makeable;
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
    ) {
    }

    public static function fromRequest(Request $request): NewUserDto
    {
        return static::make(...$request->only(['name', 'email', 'password']));
    }
}
