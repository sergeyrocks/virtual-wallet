<?php

namespace App\Http\Livewire\Transactions;

use App\Dto\TransactionCreate;
use App\Models\Wallet;
use App\Services\TransactionService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    public Wallet $wallet;
    public TransactionCreate $transaction;

    protected array $messages = [
        'transaction.amount.prohibited' => 'Value must be greater than 0',
    ];

    protected array $validationAttributes = [
        'transaction.amount' => 'Amount',
        'transaction.reference' => 'Reference',
        'transaction.payer' => 'Payer',
        'transaction.beneficiary' => 'Beneficiary',
    ];

    public function rules(): array
    {
        return [
            'transaction.is_incoming' => ['sometimes'],
            'transaction.amount' => [
                'required',
                'numeric',
                Rule::prohibitedIf($this->transaction->amount <= 0),
            ],
            'transaction.reference' => ['required', 'regex:/^([A-я :,\/.\-0-9])+$/'],
            'transaction.payer' => [
                Rule::requiredIf($this->transaction->is_incoming),
                'regex:/^([A-я :,\/.\-0-9])+$/',
            ],
            'transaction.beneficiary' => [
                Rule::requiredIf(!$this->transaction->is_incoming),
                'regex:/^([A-я :,\/.\-0-9])+$/',
                ],
        ];
    }

    public function mount(): void
    {
        $this->transaction = new TransactionCreate(
            amount: '',
            reference: '',
            payer: '',
            beneficiary: '',
        );
    }

    public function save(TransactionService $service): void
    {
        $this->validate();
        $service->create($this->wallet, $this->transaction);

        $this->redirect(route('wallets.transactions.index', $this->wallet));
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.transactions.create');
    }
}
