<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create a Room
        </h2>
    </x-slot>

    <x-jet-authentication-card>
        <x-slot name="logo"></x-slot>

        <form method="POST" action="{{ route('rooms.store') }}">
            @csrf

            <div>
                <x-jet-label for="room_number" value="{{ __('Room Number') }}" />
                <x-jet-input id="room_number" class="block mt-1 w-full" type="text" name="room_number" :value="old('room_number')" required autofocus />
            </div>
            @error('room_number')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror

            <x-jet-button class="mr-4 mt-4">
                {{ __('Create Room') }}
            </x-jet-button>

            <x-jet-button class="mt-4">
                <a href="{{ route('rooms.index') }}">{{ __('Cancel') }}</a>
            </x-jet-button>
        </form>
    </x-jet-authentication-card>
</x-app-layout>
