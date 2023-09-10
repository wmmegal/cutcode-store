@props([
    'method' => 'POST',
    'action' => ''
])

<div class="max-w-[640px] mt-12 mx-auto p-6 xs:p-8 md:p-12 2xl:p-16 rounded-[20px] bg-purple">
    @isset($title)
        <h1 class="mb-5 text-lg font-semibold">{{ $title }}</h1>
    @endisset
    <form class="space-y-3" action="{{ $action }}" method="{{ $method }}">
        @csrf
        {{ $slot }}
    </form>
        {{ $socilaButtons ?? '' }}
        {{ $servcieButtons ?? '' }}
</div>
