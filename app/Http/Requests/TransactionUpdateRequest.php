<?php

namespace App\Http\Requests;

class TransactionUpdateRequest extends TransactionStoreRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_fraudulent' => $this->is_fraudulent === 'true',
        ]);
    }

    public function rules(): array
    {
        return [
            'is_fraudulent' => 'required|boolean',
        ];
    }
}
