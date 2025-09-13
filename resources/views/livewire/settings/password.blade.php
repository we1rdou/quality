<?php
// filepath: c:\Users\flore\OneDrive\Documentos\quality\resources\views\livewire\settings\password.blade.php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Volt\Component;

new class extends Component {
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function getUserAuthTypeProperty()
    {
        $user = Auth::user();
        return !empty($user->oauth_provider) ? 'oauth' : 'password';
    }

    public function updatePassword(): void
    {
        $isOAuth = $this->getUserAuthTypeProperty() === 'oauth';

        // Validación diferente según tipo de usuario
        if ($isOAuth) {
            $this->validate([
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        } else {
            $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        }

        // Actualizar contraseña
        Auth::user()->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Password')" :subheading="__('Ensure your account is using a long, random password to stay secure.')">
        <form wire:submit="updatePassword" class="space-y-6">
            <div>
                @if ($this->getUserAuthTypeProperty() === 'oauth')
                    <!-- Para usuarios de Google -->
                    <div class="mb-6 p-4 border border-yellow-300 bg-yellow-50 dark:bg-yellow-900/20 dark:border-yellow-700 rounded-md">
                        <p class="text-sm text-yellow-700 dark:text-yellow-300">
                            {{ __('You registered using Google authentication. You need to set up a password for your account to use certain features.') }}
                        </p>
                    </div>
                @else
                    <!-- Contraseña actual para usuarios normales -->
                    <flux:input
                        wire:model="current_password"
                        :label="__('Current password')"
                        type="password"
                        autocomplete="current-password"
                        :placeholder="__('Current password')"
                        viewable
                    />
                @endif
            </div>

            <div>
                <flux:input
                    wire:model="password"
                    :label="__('New password')"
                    type="password"
                    autocomplete="new-password"
                    :placeholder="__('New password')"
                    viewable
                />
            </div>

            <div>
                <flux:input
                    wire:model="password_confirmation"
                    :label="__('Confirm password')"
                    type="password"
                    autocomplete="new-password"
                    :placeholder="__('Confirm password')"
                    viewable
                />
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="password-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>
