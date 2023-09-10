@extends('layouts.auth')

@section('title', 'Регистрация')

@section('content')
    <x-forms.auth-form title="Sign up" action="{{ route('signUp') }}">
        <x-forms.input placeholder="Name" name="name" :is-error="$errors->has('name')" value="{{ old('name') }}" required/>
        @error('name')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror
        <x-forms.input type="email" name="email" placeholder="E-mail" :is-error="$errors->has('email')" value="{{ old('email') }}" required/>
        @error('email')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <x-forms.input type="password" name="password" placeholder="Password" :is-error="$errors->has('password')"
                               required/>
                @error('password')
                <x-forms.error>
                    {{ $message }}
                </x-forms.error>
                @enderror
            </div>
            <div>
                <x-forms.input type="password" name="password_confirmation" placeholder="Repeat password"
                               :is-error="$errors->has('password_confirmation')" required/>
            </div>
        </div>
        <button type="submit" class="w-full btn btn-pink">Sign up</button>
        <x-slot:servcieButtons>
            <div class="space-y-3 mt-5">
                <div class="text-xxs md:text-xs">
                    Already have account? <a href="{{ route('login') }}"
                                     class="text-white hover:text-white/70 font-bold underline underline-offset-4">
                        Sign in
                    </a>
                </div>
            </div>
        </x-slot:servcieButtons>
    </x-forms.auth-form>
@endsection
