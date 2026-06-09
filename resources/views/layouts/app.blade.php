@if(request()->routeIs(['dashboard', 'writer.*', 'admin.*']))
    <x-layouts::app.sidebar :title="$title ?? null">
        <flux:main>
            {{ $slot }}
        </flux:main>
    </x-layouts::app.sidebar>
@else
    <x-layouts::app.header :title="$title ?? null">
        {{ $slot }}
    </x-layouts::app.header>
@endif

