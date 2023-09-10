@extends('layouts.auth')

@section('title', 'Сбросить пароль')

@section('content')
    <x-forms.auth-form title="Сбросить пароль" action="{{ route('password.email') }}">
        <x-forms.input type="email" placeholder="E-mail" name="email" :is-error="$errors->has('email')" value="{{ old('email') }}" required/>
        @error('email')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
        @enderror
        <button type="submit" class="w-full btn btn-pink">Reset password</button>
        <x-slot:servcieButtons>
            <div class="space-y-3 mt-5">
                <div class="text-xxs md:text-xs">
                    <a href="{{ route('login') }}" class="text-white hover:text-white/70 font-bold">
                        Remembered password
                    </a>
                </div>
            </div>
        </x-slot:servcieButtons>
    </x-forms.auth-form>
@endsection
