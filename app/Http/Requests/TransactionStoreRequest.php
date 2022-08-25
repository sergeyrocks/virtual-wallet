<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PositiveNumber;

class TransactionStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'is_incoming' => 'sometimes',
            'amount'      => ['required', 'numeric', new PositiveNumber],
            'reference'   => 'required|regex:/^([A-я :,\/.\-0-9])+$/',
            'payer'       => 'required_with:is_incoming|regex:/^([A-я :,\/.\-0-9])+$/',
            'beneficiary' => 'required_without:is_incoming|regex:/^([A-я :,\/.\-0-9])+$/',
        ];
    }
}
