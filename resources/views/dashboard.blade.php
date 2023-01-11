<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Latest rooms added') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="divide-y">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3">
                            Room number
                        </th>
                        <th scope="col"
                            class="px-6 py-3">
                            Status
                        </th>
                    </tr>
                    @foreach($rooms as $room)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                {{ $room->room_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($room->is_free)
                                    <span class="text-green-700">Free</span>
                                @else
                                    <span class="text-red-700">Taken</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>

                <hr />
                <x-jet-welcome />
            </div>
        </div>
    </div>
</x-app-layout>
