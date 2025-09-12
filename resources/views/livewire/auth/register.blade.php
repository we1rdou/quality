<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $address = '';
    public string $phone = '';
    public string $province = '';
    public string $city = '';
    public array $cities = [];

    public function mount(): void
    {
        $this->cities = [];
    }

    public function updatedProvince($value): void
    {
        if (!empty($value)) {
            $this->cities = config('ecuador.provinces')[$value] ?? [];
            $this->city = ''; // Reset city when province changes
        } else {
            $this->cities = [];
        }
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'province' => ['required', 'string', 'in:' . implode(',', array_keys(config('ecuador.provinces')))],
            'city' => ['required', 'string'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('Name')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('Full name')"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
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

        <!-- Phone -->
        <flux:input
            wire:model="phone"
            :label="__('Phone')"
            type="tel"
            required
            autocomplete="tel"
            :placeholder="__('Your phone number')"
        />

        <!-- Province -->
        <div>
            <label for="province" class="block text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ __('Province') }}</label>
            <select
                id="province"
                wire:model.live="province"
                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-zinc-800 dark:text-white"
                required
            >
                <option value="">{{ __('Select a province') }}</option>
                @foreach (array_keys(config('ecuador.provinces')) as $provinceOption)
                    <option value="{{ $provinceOption }}">{{ $provinceOption }}</option>
                @endforeach
            </select>
            @error('province') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
        </div>

        <!-- City -->
        <div>
            <label for="city" class="block text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ __('City') }}</label>
            <select
                id="city"
                wire:model="city"
                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-zinc-800 dark:text-white"
                required
                {{ empty($cities) ? 'disabled' : '' }}
            >
                <option value="">{{ empty($cities) ? __('Select a province first') : __('Select a city') }}</option>
                @foreach ($cities as $cityOption)
                    <option value="{{ $cityOption }}">{{ $cityOption }}</option>
                @endforeach
            </select>
            @error('city') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
        </div>

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirm password')"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        <span>{{ __('Already have an account?') }}</span>
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
