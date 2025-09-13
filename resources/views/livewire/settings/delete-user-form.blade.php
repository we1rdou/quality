<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Volt\Component;

new class extends Component {
    public string $password = '';
    public $user; // Necesitas definir esta propiedad
    public $confirmation; // Nueva propiedad para la confirmación

    // Añade el método mount para inicializar el usuario
    public function mount()
    {
        $this->user = Auth::user();
    }

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        if ($this->getUserAuthTypeProperty() === 'oauth') {
            // Para usuarios OAuth, confirmar con un mensaje
            $this->validate([
                'confirmation' => ['required', 'in:DELETE'],
            ]);
            
            $user = Auth::user();
            Auth::logout();
            $user->delete();
            Session::flush();
            
            $this->redirect('/', navigate: true);
        } else {
            // Para usuarios normales, verificamos contraseña como siempre
            $this->validate([
                'password' => ['required', 'string', 'current_password'],
            ]);

            $user = Auth::user(); // Usar directamente el usuario autenticado
            Auth::logout();
            $user->delete(); // Usar la variable local en lugar de $this->user
            Session::flush();

            $this->redirect('/', navigate: true);
        }
    }

    public function getUserAuthTypeProperty()
    {
        $user = Auth::user();
        return !empty($user->oauth_provider) ? 'oauth' : 'password';
    }
}; ?>

<section class="mt-10 space-y-6">
    <div class="relative mb-5">
        <flux:heading>{{ __('Delete account') }}</flux:heading>
        <flux:subheading>{{ __('Delete your account and all of its resources') }}</flux:subheading>
    </div>

    <flux:modal.trigger name="confirm-user-deletion">
        <flux:button variant="danger" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            {{ __('Delete account') }}
        </flux:button>
    </flux:modal.trigger>

    <flux:modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
        <form method="POST" wire:submit="deleteUser" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Are you sure you want to delete your account?') }}</flux:heading>

                <flux:subheading>
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </flux:subheading>
            </div>

            <div>
                @if ($this->getUserAuthTypeProperty() !== 'oauth')
                    <div class="col-span-6 sm:col-span-4">
                        <flux:input
                            wire:model="password"
                            :label="__('Password')"
                            type="password"
                            class="mt-1 block w-3/4"
                            :placeholder="__('Password')"
                        />
                    </div>
                @else
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Since you registered using Google, you can delete your account without providing a password.') }}
                    </p>
                @endif
            </div>

            @if ($this->getUserAuthTypeProperty() === 'oauth')
                <div>
                    <flux:input
                        wire:model="confirmation"
                        :label="__('Type DELETE to confirm')"
                        class="mt-1 block w-3/4"
                        :placeholder="__('DELETE')"
                    />
                </div>
            @endif

            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>

                <flux:button variant="danger" type="submit">{{ __('Delete account') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</section>
