<?php

$logout = function () {
    auth()->guard('web')->logout();

    session()->invalidate();
    session()->regenerateToken();

    $this->redirect('/', navigate: true);
};

?>

<div>
    <button wire:click="logout" class="flex text-gray-600 hover:text-indigo-500 align-middle font-mono text-sm rounded-xl px-2.5 py-2.5 transition duration-150 ease-in-out">
        <span>cerrar sesión</span>
    </button>
</div>
