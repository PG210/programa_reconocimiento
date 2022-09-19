@extends('principal')
@section('content')

<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <br><br>

        <form method="POST" action="{{ route('login') }}">
            @csrf

          
            @if(Session::has('errorInicio'))
                <div style="background-color:#FFE527;">
                {{Session::get('errorInicio')}}
                </div>
                <br><br>
            @endif
            <div>
                <label class="block font-medium text-sm text-gray-700" for="email" style="padding-bottom:5px;">Usuario</label>
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <!--<x-label for="password" :value="__('Contraseña')" />-->
                <label class="block font-medium text-sm text-gray-700" style="padding-bottom:5px;">Contraseña</label>

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Recordar contraseña') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Olvidó su contraseña?') }}
                    </a>
                @endif

                <x-button class="ml-3">
                    {{ __('Iniciar') }}
                </x-button>
            </div>
        </form>
        <br>
    </x-auth-card>
</x-guest-layout>



@endsection

