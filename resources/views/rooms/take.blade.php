<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Take Room {{ $room->room_number }}
        </h2>
    </x-slot>

    <x-jet-authentication-card>
        <x-slot name="logo"></x-slot>

        <form method="POST" action="{{ route('rooms.takeRoom', $room->id) }}" autocomplete="off">
            @csrf
            @method('patch')

            <div>
                <x-jet-label for="current_subject" value="{{ __('Current Subject') }}" />
                <x-jet-input id="current_subject" class="block mt-1 w-full" type="text" name="current_subject" required autofocus />
            </div>
            @error('current_subject')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror

            <x-jet-button class="mr-4 mt-4">
                {{ __('Take Room') }}
            </x-jet-button>

            <x-jet-button class="mt-4">
                <a href="{{ route('rooms.index') }}" class="block w-full">{{ __('Back To List') }}</a>
            </x-jet-button>
        </form>
    </x-jet-authentication-card>
</x-app-layout>
