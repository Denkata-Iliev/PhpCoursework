<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User Information
        </h2>
    </x-slot>

    <div class="flex">
        <div class="mt-4 w-1/3 justify-self-center self-center">
            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-auto h-3/4 m-0 m-auto"/>
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

            <button class="justify-self-center w-2/5 text-center text-white uppercase bg-gray-800 hover:bg-gray-700 rounded-md h-10 text-lg">
                <a href="{{ route('users.index') }}">Back</a>
            </button>
        </div>
    </div>
</x-app-layout>
