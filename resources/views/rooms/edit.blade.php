<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Update Room #{{ $room->room_number }}
        </h2>
    </x-slot>

    <x-jet-authentication-card>
        <x-slot name="logo"></x-slot>

        @if(session()->has('error'))
            <div class="mb-4 text-red-600">
                {{ session()->get('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('rooms.update', $room->id) }}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div>
                <x-jet-label for="room_number" value="{{ __('Room Number') }}" />
                <x-jet-input id="room_number" class="block mt-1 w-full" type="text" name="room_number" value="{{ old('room_number', $room->room_number) }}" autofocus />
            </div>
            @error('room_number')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror

            <x-jet-input type="file" name="photo" class="mt-4"/>

            <x-jet-button class="mr-4 mt-4">
                {{ __('Update Room') }}
            </x-jet-button>

            <x-jet-button class="mt-4">
                <a href="{{ route('rooms.index') }}">{{ __('Back To List') }}</a>
            </x-jet-button>
        </form>
    </x-jet-authentication-card>
</x-app-layout>
