<?php

use Illuminate\Support\Facades\Password;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.guest');

state(['email' => '']);

rules(['email' => ['required', 'string', 'email']]);

$sendPasswordResetLink = function () {
    $this->validate();

    // We will send the password reset link to this user. Once we have attempted
    // to send the link, we will examine the response then see the message we
    // need to show to the user. Finally, we'll send out a proper response.
    $status = Password::sendResetLink(
        $this->only('email')
    );

    if ($status != Password::RESET_LINK_SENT) {
        $this->addError('email', __($status));

        return;
    }

    $this->reset('email');

    session()->flash('status', __($status));
};

?>

<div>
    <div class="mb-6">
        <h1 class="text-gray-900 text-3xl font-extrabold">
            Reestablece tu contraseña
        </h1>

        <p class="text-gray-600 mt-2 text-sm">
            O <x-link to="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-400 font-medium transition-all duration-300">
                accede a tu cuenta
            </x-link>
        </p>
    </div>

    <div class="mb-4 text-sm text-gray-600">
        ¿Se te olvidó la contraseña? No te preocupes. Solo tienes que indicarnos tu email y te enviaremos un enlace para restablecer la contraseña que te permitirá elegir una nueva.
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-primary-button class="flex justify-center w-full">
                Enviar email para reestablecer contraseña
            </x-primary-button>
        </div>
    </form>
</div>
