<div>
    <script>
        window.addEventListener('open-bank-account-modal', () => {
            Livewire.dispatch('openBankAccountModal');
        });
    </script>
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div class="bg-white rounded-xl shadow-xl p-8 w-full max-w-xl relative">
                <button wire:click="closeModal" class="absolute top-3 right-3 text-slate-500 hover:text-slate-800 text-2xl">&times;</button>
                <h2 class="text-2xl font-bold mb-4 text-slate-800">Cuenta Bancaria del Dueño</h2>
                @if(session()->has('message'))
                    <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                        {{ session('message') }}
                    </div>
                @endif
                <form wire:submit.prevent="save" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Banco</label>
                        <select wire:model.defer="bank_name" class="input w-full" required>
                            <option value="">Selecciona banco</option>
                            <option value="Banco Pichincha">Banco Pichincha</option>
                            <option value="Banco Guayaquil">Banco Guayaquil</option>
                            <option value="Banco del Pacífico">Banco del Pacífico</option>
                            <option value="Produbanco">Produbanco</option>
                            <option value="Banco Internacional">Banco Internacional</option>
                            <option value="Banco Bolivariano">Banco Bolivariano</option>
                            <option value="Banco de Loja">Banco de Loja</option>
                            <option value="Banco General Rumiñahui">Banco General Rumiñahui</option>
                            <option value="Banco ProCredit">Banco ProCredit</option>
                            <option value="Cooperativa JEP">Cooperativa JEP</option>
                            <option value="Cooperativa Policía Nacional">Cooperativa Policía Nacional</option>
                            <option value="Cooperativa Alianza del Valle">Cooperativa Alianza del Valle</option>
                        </select>
                        @error('bank_name') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Número de cuenta</label>
                        <input type="text" wire:model.defer="account_number" class="input w-full" required maxlength="30" pattern="[0-9]+" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                        @error('account_number') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Tipo de cuenta</label>
                        <select wire:model.defer="account_type" class="input w-full" required>
                            <option value="">Selecciona tipo</option>
                            <option value="ahorros">Ahorros</option>
                            <option value="corriente">Corriente</option>
                        </select>
                        @error('account_type') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Titular de la cuenta</label>
                        <input type="text" wire:model.defer="account_holder" class="input w-full" required maxlength="100">
                        @error('account_holder') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Cédula de identidad</label>
                        <input type="text" wire:model.defer="ci_number" class="input w-full" required maxlength="20" pattern="[0-9]+" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                        @error('ci_number') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Teléfono de contacto</label>
                        <input type="text" wire:model.defer="phone" class="input w-full" required maxlength="20">
                        @error('phone') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-semibold">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>