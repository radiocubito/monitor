<?php

$logout = function () {
    auth()->guard('web')->logout();

    session()->invalidate();
    session()->regenerateToken();

    $this->redirect('/', navigate: true);
};

?>

<div>
    <x-nav-link wire:click.prevent="logout" class="flex" href="#">
        <span>cerrar sesión</span>
    </x-nav-link>
</div>
