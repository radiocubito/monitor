<?php

use App\Providers\RouteServiceProvider;

use function Livewire\Volt\layout;

layout('layouts.guest');

$sendVerification = function () {
    if (auth()->user()->hasVerifiedEmail()) {
        $this->redirect(
            session('url.intended', RouteServiceProvider::HOME),
            navigate: true
        );

        return;
    }

    auth()->user()->sendEmailVerificationNotification();

    session()->flash('status', 'verification-link-sent');
};

$logout = function () {
    auth()->guard('web')->logout();

    session()->invalidate();
    session()->regenerateToken();

    $this->redirect('/', navigate: true);
};

?>

<div>
    <div class="mb-4 text-sm text-gray-600">
        Gracias por registrarte. Antes de empezar, ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar? Si no lo has recibido, estaremos encantados de enviarte otro.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionaste al registrarte.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <x-primary-button wire:click="sendVerification">
            Reenviar email de verificación
        </x-primary-button>

        <button wire:click="logout" type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Cerrar sesión
        </button>
    </div>
</div>
