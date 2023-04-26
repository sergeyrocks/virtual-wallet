<form wire:submit.prevent="save"
      class="grid grid-cols-1 gap-4 py-6">

    <div class="form-control w-full max-w-xs mx-auto">
        <x-label for="is_incoming" class="cursor-pointer select-none text-sm">
            <input type="checkbox"
                   wire:model.defer="transaction.is_incoming"
                   class="checkbox checkbox-primary checkbox-xs"
                   id="is_incoming"/>
            {{ __('Incoming') }}
        </x-label>
    </div>

    <div class="form-control w-full max-w-xs mx-auto">
        <x-label for="amount">{{ __('Amount') }}</x-label>
        <input class="input-md"
               id="amount"
               type="text"
               wire:model.defer="transaction.amount"
               autofocus/>

        @error('transaction.amount')
        <span class="text-sm text-error"
              role="alert">
                    *{{ $message }}
                 </span>
        @enderror
    </div>

    <div class="form-control w-full max-w-xs mx-auto">
        <x-label for="reference">{{ __('Reference') }}</x-label>
        <input class="input-md"
               id="reference"
               type="text"
               wire:model.defer="transaction.reference"
               autofocus/>

        @error('transaction.reference')
        <span class="text-sm text-error"
              role="alert">
                    *{{ $message }}
                 </span>
        @enderror
    </div>

    <div class="form-control w-full max-w-xs mx-auto">
        <x-label for="payer">{{ __('Payer') }}</x-label>
        <input class="input-md"
               id="payer"
               type="text"
               wire:model.defer="transaction.payer"
               autofocus/>

        @error('transaction.payer')
        <span class="text-sm text-error"
              role="alert">
                    *{{ $message }}
                 </span>
        @enderror
    </div>

    <div class="form-control w-full max-w-xs mx-auto">
        <x-label for="beneficiary">{{ __('Beneficiary') }}</x-label>
        <input class="input-md"
               id="beneficiary"
               type="text"
               wire:model.defer="transaction.beneficiary"
               autofocus/>

        @error('transaction.beneficiary')
        <span class="text-sm text-error"
              role="alert">
                    *{{ $message }}
                 </span>
        @enderror
    </div>

    <div class="form-control w-full max-w-xs mx-auto">
        <button type="submit"
                class="btn btn-primary">
            {{ __('Save') }}
        </button>
        <a href="{{ route('wallets.index') }}" class="btn btn-link">{{ __('Cancel') }}</a>
    </div>
</form>
