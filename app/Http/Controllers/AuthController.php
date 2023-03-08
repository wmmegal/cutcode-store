<?php

namespace App\Http\Controllers;

use App\Contracts\RegisterUserContract;
use App\DTOs\NewUserDto;
use App\Http\Requests\PasswordEmailRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use App\Support\SessionRegenerateRunner;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;
use function Pest\Laravel\get;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function signIn(SignInFormRequest $request)
    {
        if ( ! auth()->attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'Неверный e-mail или пароль',
            ])->onlyInput('email');
        }

        SessionRegenerateRunner::run();

        return redirect()->intended(route('home'));
    }


    public function register()
    {
        return view('auth.register');
    }

    public function signUp(SignUpRequest $request, RegisterUserContract $action)
    {
        $action(NewUserDto::fromRequest($request));

        return redirect()->intended(route('home'));
    }

    public function logout()
    {
        SessionRegenerateRunner::run(fn() => auth()->logout());

        return redirect()->intended(route('home'));
    }

    public function passwordRequest()
    {
        return view('auth.lost-password');
    }

    public function passwordEmail(PasswordEmailRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            flash()->info(__($status));

            return back();
        }

        return back()->withErrors(['email' => __($status)]);
    }

    public function resetPassword($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    function passwordUpdate(PasswordUpdateRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(str()->random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            flash()->info(__($status));

            return redirect()->route('login');
        }

        return back()->withErrors(['email' => [__($status)]]);
    }

    public function github()
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubCallback()
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::updateOrCreate([
            'github_id' => $githubUser->id,
        ], [
            'name'     => $githubUser->name ?? '123',
            'email'    => $githubUser->email,
            'password' => bcrypt('password')
        ]);

        SessionRegenerateRunner::run(fn() => auth()->login($user));

        return redirect()
            ->intended(route('home'));
    }
}
