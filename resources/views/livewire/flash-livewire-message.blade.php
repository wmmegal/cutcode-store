<div>
    @if($message)
        <div class="{{ $class }} p-5" style="position: fixed; top: 0; left: 0; right: 0; z-index: 100" x-data="{show: true}" x-transition.duration.500ms x-show="show" x-cloak
        x-init="setTimeout(() => {show = false; $wire.message = ''; $wire.$refresh()}, 2000);">
            {{ $message }}
        </div>
    @endif
</div>


