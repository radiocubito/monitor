<x-layouts.app>
    <x-slot name="title">
        <div class="flex items-center">
            <span class="text-gray-800 w-full text-lg font-medium lowercase">
                {{ __('Profile') }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="max-w-xl">
                <livewire:profile.update-profile-information-form />
            </div>

            <div class="max-w-xl">
                <livewire:profile.update-password-form />
            </div>

            <div class="max-w-xl">
                <livewire:profile.delete-user-form />
            </div>
        </div>
    </div>
</x-layouts.app>
