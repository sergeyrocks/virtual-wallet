<?php

namespace App\Http\Requests;

class WalletUpdateRequest extends WalletStoreRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        unset($rules['balance']);

        return $rules;
    }

    public function messages(): array
    {
        $messages = parent::messages();
        unset($messages['balance.numeric']);

        return $messages;
    }
}
