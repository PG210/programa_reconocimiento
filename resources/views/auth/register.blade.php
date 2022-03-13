<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>
            <div>
                <x-label for="apellido" :value="__('apellido')" />

                <x-input id="apelldio" class="block mt-1 w-full" type="text" name="apellido" :value="old('apellido')" required autofocus />
            </div>
            <div>
                <x-label for="dir" :value="__('direccion')" />

                <x-input id="dir" class="block mt-1 w-full" type="text" name="dir" :value="old('dir')" required autofocus />
            </div>
            <div>
                <x-label for="telf" :value="__('telefono')" />

                <x-input id="telf" class="block mt-1 w-full" type="text" name="telf" :value="old('telf')" required autofocus />
            </div>
            <div>
                <x-label for="rol" :value="__('roles')" />

                <x-input id="rol" class="block mt-1 w-full" type="text" name="rol" :value="old('rol')" required autofocus />
            </div>
            <div>
                <x-label for="cargo" :value="__('cargo')" />

                <x-input id="cargo" class="block mt-1 w-full" type="text" name="cargo" :value="old('cargo')" required autofocus />
            </div>
            <div>
                <x-label for="estado" :value="__('estado')" />

                <x-input id="estado" class="block mt-1 w-full" type="text" name="estado" :value="old('estado')" required autofocus />
            </div>
            <div>
                <x-label for="imagen" :value="__('imagen')" />

                <x-input id="imagen" class="block mt-1 w-full" type="text" name="imagen" :value="old('imagen')" required autofocus />
            </div>
            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
