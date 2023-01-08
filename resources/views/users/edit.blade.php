<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />
        @if(session()->has('error'))
            <div class="mb-4 text-red-600">
                {{ session()->get('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('patch')

            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" value=" {{ old('name', $user->name) }}" autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email', $user->email) }}" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" />
            </div>

            <div class="mt-4">
                <x-jet-label>Role</x-jet-label>
                @foreach($roles as $role)
                    <div class="flex items-center mb-1">
                        @if($user->hasRole($role))
                            <x-jet-input checked id="role" type="radio" value="{{ $role->name }}" name="role" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                        @else
                            <x-jet-input id="role" type="radio" value="{{ $role->name }}" name="role" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                        @endif
                        <x-jet-label for="role" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $role->name }}</x-jet-label>
                    </div>
                @endforeach
            </div>

            <x-jet-button class="ml-4 mt-4 bg-blue-800 hover:bg-blue-700">
                {{ __('Update') }}
            </x-jet-button>

            <x-jet-button class="ml-4 mt-4">
                <a href="{{ route('users.index') }}" class="block w-full">Back To List</a>
            </x-jet-button>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
