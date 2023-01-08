@php use Illuminate\Support\Facades\Auth; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Room #{{ $room->room_number }}
        </h2>
    </x-slot>

    <div class="flex mr-4">
        <div class="mt-4 w-1/3 justify-self-center self-center">
            <img src="{{ $room->photo_path }}" alt="{{ $room->room_number }}" class="w-auto h-3/4 m-0 m-auto rounded-full"/>
        </div>

        <div class="grid grid-rows-3 gap-4 w-2/3">
            <div class="mt-4">
                <x-jet-label for="room_number" value="{{ __('Room Number') }}"/>
                <x-jet-input id="room_number" class="block mt-1 w-full" type="text" value=" {{ $room->room_number }}" disabled="true"/>
            </div>

            @if(!$room->is_free)
                <div class="mt-4">
                    <x-jet-label for="name" value="{{ __('Person Inside') }}"/>
                    <x-jet-input id="name" class="block mt-1 w-full" type="text" value="{{ $room->user->name }}" disabled="true"/>
                </div>

                <div class="mt-4">
                    <x-jet-label for="current_subject" value="{{ __('Current Subject') }}"/>
                    <x-jet-input id="current_subject" class="block mt-1 w-full" type="text" value="{{ $room->current_subject }}" disabled="true"/>
                </div>
            @endif

            <div class="flex gap-2">
                @can('access-rooms-crud')
                        <button class="justify-self-center w-1/4 text-center text-white uppercase bg-blue-800 hover:bg-blue-700 rounded-md h-10 text-lg">
                            <a href="{{ route('rooms.edit', $room->id) }}" class="block w-full">Edit</a>
                        </button>

                        <form class="block justify-self-center w-1/4" action="{{ route('rooms.destroy', $room->id) }}"
                              method="POST" onsubmit="return confirm('Are you sure?');">

                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <input type="submit" class="w-full text-center text-white uppercase bg-red-800 hover:bg-red-700 rounded-md h-10 text-lg cursor-pointer"
                                   value="Delete">
                        </form>
                @endcan

                @if($room->is_free)
                        <button class="justify-self-center w-1/4 text-center text-white uppercase bg-blue-800 hover:bg-blue-700 rounded-md h-10 text-lg">
                            <a href="{{ route('rooms.take', $room->id) }}" class="block w-full">Take</a>
                        </button>
                @elseif($room->user_id === Auth::user()->id
                        || Auth::user()->can('access-rooms-crud'))
                        <form class="inline-block w-1/4"
                              action="{{ route('rooms.dismiss', $room->id) }}"
                              method="POST" onsubmit="return confirm('Are you sure?');">

                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <input type="submit"
                                   class="w-full text-center text-white uppercase bg-blue-800 hover:bg-blue-700 rounded-md h-10 text-lg cursor-pointer"
                                   value="Dismiss">
                        </form>
                @endif
                <button class="justify-self-center w-2/5 text-center text-white uppercase bg-gray-800 hover:bg-gray-700 rounded-md h-10 text-lg">
                    <a href="{{ route('rooms.index') }}" class="block w-full">Back To List</a>
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
