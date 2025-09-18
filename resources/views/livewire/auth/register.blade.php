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
    // Nuevos campos
    public string $phone = '';
    public string $address = '';
    public string $province = '';
    public string $city = '';
    public array $cities = [];

    public function mount(): void
    {
        // Inicializar array de ciudades vacío
        $this->cities = [];
    }

    public function updatedProvince($value): void
    {
        if (!empty($value)) {
            $this->cities = config('ecuador.provinces')[$value] ?? [];
            $this->city = ''; // Resetear ciudad cuando cambia la provincia
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
            // Validación para los nuevos campos
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'in:' . implode(',', array_keys(config('ecuador.provinces')))],
            'city' => ['required', 'string'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        // Redirigir al login después del registro
        $this->redirect(route('login'), navigate: true);
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
                           text-zinc-400 dark:text-zinc-400 border border-zinc-300 dark:border-zinc-600 
                           rounded-lg dark:rounded-md shadow-sm ring-1 ring-inset ring-zinc-300 dark:ring-zinc-700
                           focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
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

    <!-- Separador con texto -->
    <div class="relative mt-4">
        <div class="absolute inset-0 flex items-center">
            <span class="w-full border-t border-gray-300 dark:border-gray-700"></span>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white dark:bg-zinc-900 text-gray-500 dark:text-gray-400">
                {{ __('Or continue with') }}
            </span>
        </div>
    </div>

    <!-- Botón de Google -->
    <div class="mt-4">
        <a href="{{ route('auth.google') }}" class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-zinc-800 hover:bg-gray-50 dark:hover:bg-zinc-700">
            <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <g transform="matrix(1, 0, 0, 1, 27.009001, -39.238998)">
                    <path fill="#4285F4" d="M -3.264 51.509 C -3.264 50.719 -3.334 49.969 -3.454 49.239 L -14.754 49.239 L -14.754 53.749 L -8.284 53.749 C -8.574 55.229 -9.424 56.479 -10.684 57.329 L -10.684 60.329 L -6.824 60.329 C -4.564 58.239 -3.264 55.159 -3.264 51.509 Z"/>
                    <path fill="#34A853" d="M -14.754 63.239 C -11.514 63.239 -8.804 62.159 -6.824 60.329 L -10.684 57.329 C -11.764 58.049 -13.134 58.489 -14.754 58.489 C -17.884 58.489 -20.534 56.379 -21.484 53.529 L -25.464 53.529 L -25.464 56.619 C -23.494 60.539 -19.444 63.239 -14.754 63.239 Z"/>
                    <path fill="#FBBC05" d="M -21.484 53.529 C -21.734 52.809 -21.864 52.039 -21.864 51.239 C -21.864 50.439 -21.724 49.669 -21.484 48.949 L -21.484 45.859 L -25.464 45.859 C -26.284 47.479 -26.754 49.299 -26.754 51.239 C -26.754 53.179 -26.284 54.999 -25.464 56.619 L -21.484 53.529 Z"/>
                    <path fill="#EA4335" d="M -14.754 43.989 C -12.984 43.989 -11.404 44.599 -10.154 45.789 L -6.734 42.369 C -8.804 40.429 -11.514 39.239 -14.754 39.239 C -19.444 39.239 -23.494 41.939 -25.464 45.859 L -21.484 48.949 C -20.534 46.099 -17.884 43.989 -14.754 43.989 Z"/>
                </g>
            </svg>
            {{ __('Continue with Google') }}
        </a>
    </div>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        <span>{{ __('Already have an account?') }}</span>
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
