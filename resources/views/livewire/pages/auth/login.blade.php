<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.guest');

state(['email' => '', 'password' => '', 'remember' => false]);

rules([
    'email' => ['required', 'string', 'email'],
    'password' => ['required', 'string'],
    'remember' => ['boolean'],
]);

$login = function () {
    $this->validate();

    $throttleKey = Str::transliterate(Str::lower($this->email).'|'.request()->ip());

    if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($throttleKey);

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    if (! auth()->attempt($this->only(['email', 'password'], $this->remember))) {
        RateLimiter::hit($throttleKey);

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    RateLimiter::clear($throttleKey);

    session()->regenerate();

    $this->redirect(
        session('url.intended', RouteServiceProvider::HOME),
        navigate: true
    );
};

?>

<div>
    <div>
        <h1 class="text-gray-900 text-3xl font-extrabold">
            Acceder a tu cuenta
        </h1>
        <p class="text-gray-600 mt-2 text-sm">
            O <x-link to="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-400 font-medium transition-all duration-300">
                crear una cuenta nueva
            </x-link>
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mt-6" :status="session('status')" />

    <form class="mt-6" wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Contraseña" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex justify-between mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="remember" id="remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">Mantener sesión iniciada</span>
            </label>

            @if (Route::has('password.request'))
                <x-link href="{{ route('password.request') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    ¿Olvidaste tu contraseña?
                </x-link>
            @endif
        </div>

        <div class="mt-4">
            <x-primary-button class="w-full justify-center">
                Iniciar sesión
            </x-primary-button>
        </div>
    </form>
</div>
