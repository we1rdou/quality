<?php

namespace App\Livewire\Owner;

use App\Models\BankAccount;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BankAccountFormModal extends Component
{
    public $showModal = false;
    public $bank_name = '';
    public $account_number = '';
    public $account_type = '';
    public $account_holder = '';
    public $ci_number = '';
    public $phone = '';

    protected $listeners = ['openBankAccountModal' => 'openModal'];

    public function mount()
    {
        $owner = Auth::user();
        $account = $owner->bankAccount;
        if ($account) {
            $this->bank_name = $account->bank_name;
            $this->account_number = $account->account_number;
            $this->account_type = $account->account_type;
            $this->account_holder = $account->account_holder;
            $this->ci_number = $account->ci_number;
            $this->phone = $account->phone;
        } else {
            $this->account_holder = $owner->name;
            $this->phone = $owner->phone ?? '';
        }
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function save()
    {
        $this->validate([
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|digits_between:5,30',
            'account_type' => 'required|string|max:30',
            'account_holder' => 'required|string|max:100',
            'ci_number' => 'required|digits_between:8,20',
            'phone' => 'required|string|max:20',
        ]);

        $owner = Auth::user();
        $owner->bankAccount()->updateOrCreate([], [
            'bank_name' => $this->bank_name,
            'account_number' => $this->account_number,
            'account_type' => $this->account_type,
            'account_holder' => $this->account_holder,
            'ci_number' => $this->ci_number,
            'phone' => $this->phone,
        ]);

        session()->flash('message', 'Cuenta bancaria guardada correctamente.');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.owner.bank-account-form-modal');
    }
}