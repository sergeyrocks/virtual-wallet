<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WalletStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|regex:/^([A-я _.\-0-9])+$/',
            'balance' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'A title is required',
            'title.regex' => 'The title format is invalid. Allowed uppercase and lowercase letters, number and symbols: ". -_"',
            'balance.numeric' => 'The balance must be a number. Use "." for decimals.',
        ];
    }
}
