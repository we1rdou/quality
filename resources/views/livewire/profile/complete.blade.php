<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $address = '';
    public string $phone = '';
    public string $province = '';
    public string $city = '';
    public $cities = []; // Sin type hint
    
    public function mount(): void
    {
        $this->address = Auth::user()->address ?? '';
        $this->phone = Auth::user()->phone ?? '';
        $this->province = Auth::user()->province ?? '';
        $this->city = Auth::user()->city ?? '';
        
        if (!empty($this->province)) {
            $this->cities = config('ecuador.provinces')[$this->province] ?? [];
        }
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
    
    public function completeProfile(): void
    {
        $validated = $this->validate([
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'province' => ['required', 'string', 'in:' . implode(',', array_keys(config('ecuador.provinces')))],
            'city' => ['required', 'string'],
        ]);
        
        $user = Auth::user();
        $user->fill($validated);
        $user->save();
        
        session()->forget('needs_profile_completion');
        
        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
    
    // Métodos auxiliares para la vista
    public function isCityDisabled()
    {
        return empty($this->cities);
    }
    
    public function getCityPlaceholder()
    {
        return empty($this->cities) ? __('Select a province first') : __('Select a city');
    }
    
    public function getCities()
    {
        return $this->cities;
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Complete your profile')" :description="__('Please provide the following information to complete your registration')" />

    <form wire:submit="completeProfile" class="flex flex-col gap-6">
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

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Complete Profile') }}
            </flux:button>
        </div>
    </form>
</div>