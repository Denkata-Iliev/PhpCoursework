@php use Illuminate\Support\Facades\Auth; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rooms List
        </h2>
    </x-slot>

    <div>
        <div class="max-w-6xl mx-auto py-10 sm:px-6 lg:px-8">
            @can('access-rooms-crud')
                <div class="block mb-4">
                    <a href="{{ route('rooms.create') }}"
                       class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add Room</a>
                </div>
            @endcan

            <form class="mb-2" method="POST" action="{{ route('rooms.search') }}">
                @csrf
                <input type="text" placeholder="{{ __('Search') }}" name="roomNumber" class="block rounded p-1"/>
                <div>
                    <input type="checkbox" placeholder="{{ __('Search') }}" name="isFree" id="isFree" class="rounded p-1"/>
                    <label for="isFree">Free</label>
                </div>
                <x-jet-secondary-button type="submit">{{ __('Search') }}</x-jet-secondary-button>
            </form>

            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 w-full">
                                <thead>
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Room Number
                                        </th>

                                        <th scope="col"
                                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Subject Currently Taught
                                        </th>

                                        <th scope="col"
                                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Free/Taken
                                        </th>

                                        <th scope="col"
                                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Person Inside
                                        </th>

                                        <th scope="col" class="px-6 py-3 bg-gray-50"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($rooms as $room)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $room->room_number }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $room->current_subject }}
                                        </td>

                                        @if($room->is_free)
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Free
                                                </span>
                                            </td>
                                        @else
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Taken
                                                </span>
                                            </td>
                                        @endif

                                        @if(!is_null($room->user))
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $room->user->name }}
                                            </td>
                                        @else
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                                        @endif

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('rooms.show', $room->id) }}"
                                               class="text-blue-600 hover:text-blue-900 mb-2 mr-2">View</a>

                                            @if($room->is_free)
                                                <a href="{{ route('rooms.take', $room->id) }}"
                                                   class="text-green-600 hover:text-green-900 mb-2 mr-2">Take</a>

                                            @elseif($room->user_id === Auth::user()->id
                                                || Auth::user()->can('access-rooms-crud'))
                                                <form class="inline-block"
                                                      action="{{ route('rooms.dismiss', $room->id) }}"
                                                      method="POST" onsubmit="return confirm('Are you sure?');">

                                                    <input type="hidden" name="_method" value="PATCH">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                    <input type="submit"
                                                           class="text-green-600 hover:text-green-900 mb-2 mr-2 cursor-pointer"
                                                           value="Dismiss">
                                                </form>
                                            @endif

                                            @can('access-rooms-crud')
                                                <a href="{{ route('rooms.edit', $room->id) }}"
                                                   class="text-indigo-600 hover:text-indigo-900 mb-2 mr-2">Edit</a>

                                                <form class="inline-block"
                                                      action="{{ route('rooms.destroy', $room->id) }}"
                                                      method="POST" onsubmit="return confirm('Are you sure?');">

                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                    <input type="submit"
                                                           class="text-red-600 hover:text-red-900 mb-2 mr-2 cursor-pointer"
                                                           value="Delete">
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
