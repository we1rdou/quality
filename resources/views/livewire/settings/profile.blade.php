<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';
    public string $address = '';
    public string $phone = '';
    public string $province = '';
    public string $city = '';
    public array $cities = [];

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->address = Auth::user()->address ?? '';
        $this->phone = Auth::user()->phone ?? '';
        $this->province = Auth::user()->province ?? '';
        $this->city = Auth::user()->city ?? '';
        
        // Cargar ciudades si hay provincia seleccionada
        if ($this->province) {
            $this->cities = config('ecuador.provinces')[$this->province] ?? [];
        }
    }
    
    /**
     * Actualiza las ciudades cuando cambia la provincia
     */
    public function updatedProvince($value): void
    {
        if (!empty($value)) {
            $this->cities = config('ecuador.provinces')[$value] ?? [];
            // Solo reiniciar ciudad si no existe en la nueva lista de ciudades
            if (!in_array($this->city, $this->cities)) {
                $this->city = '';
            }
        } else {
            $this->cities = [];
            $this->city = '';
        }
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id)
            ],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'province' => ['nullable', 'string', 'in:' . implode(',', array_keys(config('ecuador.provinces')))],
            'city' => ['nullable', 'string'],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your account information')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <!-- Name field -->
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <!-- Email field with verification -->
            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Address field -->
            <flux:input wire:model="address" :label="__('Address')" type="text" autocomplete="street-address" />

            <!-- Phone field -->
            <flux:input wire:model="phone" :label="__('Phone')" type="tel" autocomplete="tel" />

            <!-- Province field -->
            <div>
                <label for="province" class="block text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ __('Province') }}</label>
                <select
                    id="province"
                    wire:model.live="province"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-zinc-800 dark:text-white"
                >
                    <option value="">{{ __('Select a province') }}</option>
                    @foreach (array_keys(config('ecuador.provinces')) as $provinceOption)
                        <option value="{{ $provinceOption }}">{{ $provinceOption }}</option>
                    @endforeach
                </select>
            </div>

            <!-- City field -->
            <div>
                <label for="city" class="block text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ __('City') }}</label>
                <select
                    id="city"
                    wire:model="city"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-zinc-800 dark:text-white"
                    {{ empty($cities) ? 'disabled' : '' }}
                >
                    <option value="">{{ empty($cities) ? __('Select a province first') : __('Select a city') }}</option>
                    @foreach ($cities as $cityOption)
                        <option value="{{ $cityOption }}">{{ $cityOption }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Save button and confirmation message -->
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
