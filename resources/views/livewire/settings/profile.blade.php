<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $address = '';
    public string $province = '';
    public string $city = '';
    public array $cities = [];

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->address = $user->address ?? '';
        $this->province = $user->province ?? '';
        $this->city = $user->city ?? '';
        
        if (!empty($this->province)) {
            $this->cities = config('ecuador.provinces')[$this->province] ?? [];
        }
    }

    /**
     * Actualizar las ciudades cuando cambia la provincia
     */
    public function updatedProvince($value): void
    {
        if (!empty($value)) {
            $this->cities = config('ecuador.provinces')[$value] ?? [];
            $this->city = '';
        } else {
            $this->cities = [];
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

            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'in:' . implode(',', array_keys(config('ecuador.provinces')))],
            'city' => ['required', 'string'],
        ]);

        $user->fill($validated);
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
            <!-- Name -->
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <!-- Email (no editable) -->
            <div>
                <label for="email" class="block text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ __('Email') }}</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <div class="relative flex items-center flex-grow">
                        <input
                            id="email"
                            type="email"
                            value="{{ $email }}"
                            readonly
                            class="mt-1 h-10 appearance-none text-sm block w-full px-4 bg-zinc-100 dark:bg-zinc-700
                                   text-zinc-900 dark:text-zinc-300 border border-zinc-300/50 dark:border-zinc-600
                                   rounded-lg dark:rounded-md shadow-sm cursor-not-allowed"
                        />
                    </div>
                </div>
                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                    {{ __('Email address cannot be changed for security reasons.') }}
                </p>
            </div>

            <!-- Phone -->
            <flux:input
                wire:model="phone"
                :label="__('Phone')"
                type="tel"
                required
                autocomplete="tel"
                :placeholder="__('Your phone number')"
            />

            <!-- Address -->
            <flux:input
                wire:model="address"
                :label="__('Address')"
                type="text"
                required
                autocomplete="street-address"
                :placeholder="__('Your address')"
            />

            <!-- Province -->
            <div>
                <label for="province" class="block text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ __('Province') }}</label>
                <div class="relative">
                    <select
                        id="province"
                        wire:model.live="province"
                        class="mt-1 h-10 appearance-none text-sm block w-full px-4 bg-white dark:bg-zinc-800 
                               text-zinc-400 dark:text-zinc-400 border border-zinc-300/50 dark:border-zinc-700 
                               rounded-lg dark:rounded-md shadow-sm 
                               focus:border-indigo-500 focus:ring-0 focus:outline-none"
                        required
                    >
                        <option value="" class="text-zinc-400 dark:text-zinc-400">{{ __('Select a province') }}</option>
                        @foreach (array_keys(config('ecuador.provinces')) as $provinceOption)
                            <option value="{{ $provinceOption }}" class="text-zinc-900 dark:text-zinc-100">{{ $provinceOption }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-zinc-400">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
                @error('province') <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- City -->
            <div>
                <label for="city" class="block text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ __('City') }}</label>
                <div class="relative">
                    <select
                        id="city"
                        wire:model="city"
                        class="mt-1 h-10 appearance-none text-sm block w-full px-4 bg-white dark:bg-zinc-800 
                               text-zinc-400 dark:text-zinc-400 border border-zinc-300/50 dark:border-zinc-700 
                               rounded-lg dark:rounded-md shadow-sm 
                               focus:border-indigo-500 focus:ring-0 focus:outline-none"
                        required
                        {{ empty($cities) ? 'disabled' : '' }}
                    >
                        <option value="" class="text-zinc-400 dark:text-zinc-400">{{ empty($cities) ? __('Select a province first') : __('Select a city') }}</option>
                        @foreach ($cities as $cityOption)
                            <option value="{{ $cityOption }}" class="text-zinc-900 dark:text-zinc-100">{{ $cityOption }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-zinc-400">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
                @error('city') <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> @enderror
            </div>

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
