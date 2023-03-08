<?php

namespace App\Actions;

use App\Contracts\RegisterUserContract;
use App\DTOs\NewUserDto;
use App\Models\User;
use App\Support\SessionRegenerateRunner;
use Illuminate\Auth\Events\Registered;

class RegisterUserAction implements RegisterUserContract
{
    public function __invoke(NewUserDto $data): void
    {
        $user = User::create([
            'name'     => $data->name,
            'email'    => $data->email,
            'password' => bcrypt($data->password),
        ]);

        event(new Registered($user));
        SessionRegenerateRunner::run(fn() => auth()->login($user));
    }
}
