@extends('layouts.auth')

@section('content')
    @auth
        <form action="{{ route('logout') }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-primary">Выйти</button>
        </form>
    @endauth
@endsection
