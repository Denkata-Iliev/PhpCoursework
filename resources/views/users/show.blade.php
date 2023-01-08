<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User Information
        </h2>
    </x-slot>

    <div class="flex mr-4">
        <div class="mt-4 w-1/3 justify-self-center self-center">
            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-auto h-3/4 m-0 m-auto rounded-full"/>
        </div>

        <div class="grid grid-rows-3 gap-4 w-2/3">
            <div class="mt-4">
                <x-jet-label for="name" value="{{ __('Name') }}"/>
                <x-jet-input id="name" class="block mt-1 w-full" type="text" value=" {{ $user->name }}" disabled="true"/>
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}"/>
                <x-jet-input id="email" class="block mt-1 w-full" type="text" value="{{ $user->email }}" disabled="true"/>
            </div>

            <div class="mt-4">
                    <x-jet-label for="role" value="{{ __('Role') }}"/>
                @foreach($user->getRoleNames() as $roleName)
                    <x-jet-input id="role" class="block mt-1 w-full" type="text" value="{{ $roleName }}" disabled="true"/>
                @endforeach
            </div>

            <div class="flex gap-2">
                <button class="justify-self-center w-2/5 text-center text-white uppercase bg-blue-800 hover:bg-blue-700 rounded-md h-10 text-lg">
                    <a href="{{ route('users.edit', $user->id) }}" class="block w-full">Edit</a>
                </button>

                <form class="block justify-self-center w-2/5" action="{{ route('users.destroy', $user->id) }}"
                      method="POST" onsubmit="return confirm('Are you sure?');">

                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <input type="submit" class="w-full text-center text-white uppercase bg-red-800 hover:bg-red-700 rounded-md h-10 text-lg cursor-pointer"
                           value="Delete">
                </form>

                <button class="justify-self-center w-2/5 text-center text-white uppercase bg-gray-800 hover:bg-gray-700 rounded-md h-10 text-lg">
                    <a href="{{ route('users.index') }}" class="block w-full">Back To List</a>
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
