@extends('layouts.auth')

@section('title', 'Вход в аккаунт')

@section('content')
    <x-forms.auth-form
        title="Вход в аккаунт"
        :action="route('signIn')"
    >
        <x-forms.input type="email" name="email" placeholder="E-mail" :is-error="$errors->has('email')" value="{{ old('email') }}" required/>
        <x-forms.input name="password" type="password" placeholder="Password" :is-error="$errors->has('email')" required/>
        @error('email')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror
        <button type="submit" class="w-full btn btn-pink">Login</button>

        <x-slot:servcieButtons>
            <div class="space-y-3 mt-5">
                <div class="text-xxs md:text-xs">
                    <a href="{{ route('password.request') }}" class="text-white hover:text-white/70 font-bold">
                       Forgot password?
                    </a>
                </div>
                <div class="text-xxs md:text-xs">
                    <a href="{{ route('register') }}" class="text-white hover:text-white/70 font-bold">
                       Registration
                    </a>
                </div>
            </div>
        </x-slot:servcieButtons>
    </x-forms.auth-form>
@endsection
