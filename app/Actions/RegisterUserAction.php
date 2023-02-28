<?php

namespace App\Actions;

use App\Contracts\RegisterUserContract;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class RegisterUserAction implements RegisterUserContract
{
    public function __invoke(string $name, string $email, string $password): void
    {
        $user = User::create([
            'name'     => $name,
            'email'    => $email,
            'password' => bcrypt($password),
        ]);

        event(new Registered($user));
        auth()->login($user);
    }
}
