<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="password_confirmation" />
            </div>

            <div class="mt-4">
                <x-jet-label>Role</x-jet-label>
                @foreach($roles as $role)
                    <div class="flex items-center mb-1">
                        <x-jet-input checked id="role" type="radio" value="{{ $role->name }}" name="role" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                        <x-jet-label for="role" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $role->name }}</x-jet-label>
                    </div>
                @endforeach
            </div>

            <x-jet-button class="ml-4 mt-4">
                {{ __('Create') }}
            </x-jet-button>

            <x-jet-button class="ml-4 mt-4">
                <a href="{{ route('users.index') }}">Cancel</a>
            </x-jet-button>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
