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
    public array $cities = [];
    
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

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Complete Profile') }}
            </flux:button>
        </div>
    </form>
</div>