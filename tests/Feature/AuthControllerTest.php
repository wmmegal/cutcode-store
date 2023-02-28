<?php

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\delete;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('register users', function () {
    Event::fake();

    $data = [
        'name'                  => 'Name',
        'email'                 => 'test@gmail.com',
        'password'              => '123456789',
        'password_confirmation' => '123456789',
    ];

    assertDatabaseMissing('users', [
        'email' => $data['email']
    ]);

    $response = post(
        action([AuthController::class, 'signUp']),
        $data
    );

    $response->assertValid();

    Event::assertDispatched(Registered::class);

    assertDatabaseHas('users', [
        'email' => $data['email']
    ]);

    $user = User::where('email', $data['email'])->first();

    assertAuthenticatedAs($user);
    $response->assertRedirect(route('home'));
});

it('sign in', function () {
    $password = '123456789';
    $user     = User::create([
        'name'     => 'Name',
        'email'    => 'test@gmail.com',
        'password' => bcrypt($password)
    ]);

    $data = [
        'email'    => $user->email,
        'password' => $password
    ];

    $response = post(
        action([AuthController::class, 'signIn']),
        $data
    );

    assertAuthenticatedAs($user);
    $response->assertRedirect(route('home'));
});

it('logout', function () {
    $user = User::create([
        'name'     => 'Name',
        'email'    => 'test@gmail.com',
        'password' => bcrypt('123456789'),
        'remember_token' => null
    ]);

    actingAs($user);
    delete(action([AuthController::class, 'logout']));

    assertGuest();
});

