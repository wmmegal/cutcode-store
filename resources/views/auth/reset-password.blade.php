@extends('layouts.auth')

@section('title', 'Восстановление пароля')

@section('content')
    <x-forms.auth-form title="Восстановление пароля" action="{{ route('password.update') }}">
        <input type="hidden" name="token" value="{{ $token }}">
        <x-forms.input type="email" placeholder="E-mail" name="email" :is-error="$errors->has('email')" value="{{ request('email') }}" required/>
        @error('email')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
        @enderror
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <x-forms.input type="password" name="password" placeholder="Пароль" :is-error="$errors->has('password')"
                               required/>
                @error('password')
                <x-forms.error>
                    {{ $message }}
                </x-forms.error>
                @enderror
            </div>
            <div>
                <x-forms.input type="password"
                               name="password_confirmation"
                               placeholder="Повторно пароль"
                               :is-error="$errors->has('password_confirmation')" required/>
            </div>
        </div>
        <button type="submit" class="w-full btn btn-pink">Подтвердить</button>
    </x-forms.auth-form>
@endsection
